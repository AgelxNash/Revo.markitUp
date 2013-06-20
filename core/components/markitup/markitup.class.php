<?php
/**
 * @package markitup
 */
class markitup{

    private $_cfg = array(); //Конфиги MODX
    private $_settings = array(); //Индивидуальные конфиги редакторов
    private $_script = array(); //Коллекция редакторов на загрузку
    private $_ajaxload = false; //Статус загрузки через AjaxManager

    public $_modx = null; //Экземпляр класса modX

    public function __construct(modX &$modx) {
        $this->_modx =& $modx;

        $assetsUrl  = $this->getOption('markitup.assets_url',null,$this->getOption('assets_url',null,MODX_ASSETS_URL).'components/markitup/');
        $corePath   = $this->getOption('markitup.core_path',null,$this->getOption('core_path',null,MODX_CORE_PATH).'components/markitup/');
        $editorSettings = $this->getOption('markitup.settings',null,'');
        $editorSkin = trim(trim($this->getOption('markitup.skin',null,'modx')),'/');

        $this->_cfg = array(
            'corePath' => $corePath,
            'assetsUrl' => $assetsUrl,
            'editorSettings' => $editorSettings,
            'editorSkin' => $editorSkin
        );

        $this->lexiconLoad('markitup:default');
    }

    public function mainLoad() {
        $this->addLexicon( //Подгрузка лексикона
            'markitup:default'
        )->addJS( //Путь к jQuery http://code.jquery.com/jquery-1.8.0.min.js
            $this->getOption('markitup.jquery','',$this->_cfg['assetsUrl'].'jquery/1.8.3.min.js')
        )->addJS( //От куда грузить редактор http://markitup.jaysalvat.com/examples/markitup/jquery.markitup.js
            $this->getOption('markitup.editorjs','',$this->_cfg['assetsUrl'].'markitup/jquery.markitup.js')
        )->addCSS( //Стили самого редактора
            $this->_cfg['assetsUrl'].'markitup/skins/'.$this->_cfg['editorSkin'].'/style.css'
        )->addCSS( //Стили кнопок. Нужно заранее озвучить какие классы имеются в наличии
            $this->getOption('markitup.css_button','',$this->_cfg['assetsUrl'].'markitup/sets/full/style.css')
        );

        //Произвольный JavaScript для каллбеков. Скрипты разделяются символом ###
        $customJs =  $this->getOption('markitup.custom_js','','');
        if(!empty($customJs)){
            $customJs = explode("###",$customJs);
            foreach($customJs as $js){
                $this->addJS($js);
            }
        }
        return $this;
    }

    //@SEE: http://api.yandex.ru/speller/doc/dg/reference/speller-js.xml
    public function speller(){
        $flag = false;
        if(!$this->getOption('markitup.speller_disable','',false)){
            $spellJS=$this->getOption('markitup.spellerJS','',$this->_cfg['assetsUrl'].'spell/http/spell.js');
            $this->addJS($spellJS);

            $spellOptions = $this->getOption('markitup.speller_options','','Speller.IGNORE_URLS + Speller.FIND_REPEAT');
            $spellerCfg = array(
                'url'=> dirname($spellJS),
                'lang'=>$this->getOption('markitup.speller_lang','',$this->getOption('cultureKey')),
                'options'=>$spellOptions
            );
            $spellerCfg=$this->toJson($spellerCfg);
            $spellerCfg = str_replace('"'.$spellOptions.'"',$spellOptions,$spellerCfg);
            $this->collectScript('
                var speller = new Speller('.$spellerCfg.');
            ','main');
            $flag = true;
        }
        return $flag;
    }

    public function showEditor($field='#ta',$mode='main'){
        $settings = $this->getSettings(str_replace("#","",$field));

        $this->collectScript('
            $(\''.$field.'\').markItUp('.$settings.');
        ',$mode);

        return $this;
    }

    public function onReady(){
        if(!$this->_ajaxload){
            $this->mainLoad()->speller();
            $this->_ajaxload = true;
        }

        $this->addHtml('<script>
            Ext.onReady(function() {
                '.$this->getScript('main').'
            });
            MODx.afterTVLoad = function() {
                '.$this->getScript('tv').'
            };
        </script>');
        return $this;
    }

    protected function getSettings($propName){
        if(!isset($this->_settings[$propName])){
            $setting =  (!empty($propName)) ? $this->getOption('markitup.settings_'.$propName,null,'') : '';
            if(empty($setting)){
                $this->_settings[$propName] = $this->_cfg['editorSettings'];
            }else{
                $this->_settings[$propName] = $setting;
            }
        }
        return $this->_settings[$propName];
    }

    protected function getScript($mode='main'){
        $script = isset($this->_script[$mode]) ? $this->_script[$mode] : '';
        return implode("\r\n",$script);
    }

    protected function collectScript($script,$mode='main'){
        if(!empty($script) && is_scalar($script)){
            $script=trim($script);
            if(substr($script,-1,1)!=';'){
                $script .= ';';
            }
            $this->_script[$mode][] = $script;
        }
        return $this;
    }

    private function toJson($array){
        return $this->_modx->toJson($array);
    }
    private function addPackage($pkg= '', $path= '', $prefix= null) {
        $this->_modx->addPackage($pkg,$path,$prefix);
    }
    private function lexiconLoad($element){
        $this->_modx->lexicon->load($element);
    }
    private function getOption($key, $options = null, $default = null, $skipEmpty = false) {
        return $this->_modx->getOption($key, $options, $default, $skipEmpty);
    }
    private function addLexicon($element){
        $this->_modx->controller->addLexiconTopic($element);
        return $this;
    }
    private function addCSS($element){
        //$this->_modx->regClientCSS($element);
        $this->_modx->controller->addCss($element);
        return $this;
    }
    private function addJS($element){
        //$this->_modx->regClientStartupScript($element)
        $this->_modx->controller->addJavascript($element);
        return $this;
    }
    private function addHtml($element){
        $this->_modx->controller->addHtml($element);
        return $this;
    }
}