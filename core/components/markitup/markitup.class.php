<?php
/**
 * Компонент с HTML редактором MarkitUp! {@link http://markitup.jaysalvat.com/home/}
 *
 * @package markitup
 */
class markitup
{
    /**
     * @var array Глобальные конфиги компонента
     */
    private $_cfg = array();

    /**
     * @var array Индивидуальные конфиги редакторов
     */
    private $_settings = array();

    /**
     * @var array коллекция скриптов для загрузки
     */
    private $_script = array();

    /**
     * @var bool Статус загрузки элементов через controller. Для совместимости с AjaxManager и избежания повторных загрузок
     */
    private $_ajaxload = false;

    /**
     * @var modX|null Ссылка на экземпляр класса modX
     */
    private $_modx = null;

    /**
     * @var null|string Имя текущего пакета (зависит от имени класса)
     */
    private $_pkgName = null;

    /**
     * Конструктор класса markitup
     *
     * @param modX $modx ссылка на экземпляр класса modX
     */
    public function __construct(modX &$modx)
    {
        $this->_modx =& $modx;
        $this->_pkgName = __CLASS__;

        $this->_cfg = array(
            'corePath' => $this->getOption($this->optName('core_path'), null, $this->getOption('core_path', null, MODX_CORE_PATH) . 'components/markitup/'),
            'assetsUrl' => $this->getOption($this->optName('assets_url'), null, $this->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/markitup/'),
            'editorSettings' => $this->getOption($this->optName('settings'), null, ''),
            'editorSkin' => trim(trim($this->getOption($this->optName('skin'), null, 'modx')), '/'),
			'loadJquery' => $this->getOption($this->optName('loadJquery'), null, '1'),
			'AjaxManager' => $this->getOption($this->optName('AjaxManager'), null, '1'),
        );

        $this->lexiconLoad($this->optName(':default',':'));
    }

    /**
     * Выполняет загрузку основных JS скриптов необходимых для работы компонента
     *
     * @return $this
     */
    public function mainLoad()
    {
        $this->addLexicon( //Подгрузка лексикона
            $this->optName('default',':')
        );
		
		if($this->_cfg['loadJquery']){
			$this->addJS( //Путь к jQuery http://code.jquery.com/jquery-1.8.0.min.js
                $this->getOption($this->optName('jquery'), '', $this->_cfg['assetsUrl'] . 'jquery/1.8.3.min.js')
			);
		}
		
		$this->addJS( //От куда грузить редактор http://markitup.jaysalvat.com/examples/markitup/jquery.markitup.js
                $this->getOption($this->optName('editorjs'), '', $this->_cfg['assetsUrl'] . 'markitup/jquery.markitup.js')
            )->addCSS( //Стили самого редактора
                $this->_cfg['assetsUrl'] . 'markitup/skins/' . $this->_cfg['editorSkin'] . '/style.css'
            )->addCSS( //Стили кнопок. Нужно заранее озвучить какие классы имеются в наличии
                $this->getOption($this->optName('css_button'), '', $this->_cfg['assetsUrl'] . 'markitup/sets/full/style.css')
            );
        //Произвольный JavaScript для каллбеков. Скрипты разделяются символом ###
        $customJs = $this->getOption($this->optName('custom_js'), '', '');
        if (!empty($customJs)) {
            $customJs = explode("###", $customJs);
            foreach ($customJs as $js) {
                $this->addJS($js);
            }
        }
        return $this;
    }

    /**
     * Загрузка Yandex спеллера
     * @see http://api.yandex.ru/speller/doc/dg/reference/speller-js.xml описание методов API Yandex.Спеллера
     *
     * @return $this
     */
    public function speller()
    {
        if (!$this->getOption($this->optName('speller_disable'), '', false)) {
            $spellJS = $this->getOption($this->optName('spellerJS'), '', $this->_cfg['assetsUrl'] . 'spell/http/spell.js');
            $this->addJS($spellJS);

            $spellOptions = $this->getOption($this->optName('speller_options'), '', 'Speller.IGNORE_URLS + Speller.FIND_REPEAT');
            $spellerCfg = array(
                'url' => dirname($spellJS),
                'lang' => $this->getOption($this->optName('speller_lang'), '', $this->getOption('cultureKey')),
                'options' => $spellOptions
            );
            $spellerCfg = $this->toJson($spellerCfg);
            $spellerCfg = str_replace('"' . $spellOptions . '"', $spellOptions, $spellerCfg);
            $this->collectScript('
                var speller = new Speller(' . $spellerCfg . ');
            ', 'main');
            $flag = true;
        }
        return $this;
    }

    /**
     * ID поля textarea к которому необходимо подключить MarkitUp!
     *
     * @param string $field ID поля с префиксом #
     * @param string $mode расположнеие поля (основной документ или TV параметры)
     * @return $this
     */
    public function showEditor($field = '#ta', $mode = 'main')
    {
        $settings = $this->getSettings(str_replace("#", "", $field));

        $this->collectScript('
            $(\'' . $field . '\').markItUp(' . $settings . ');
        ', $mode);

        return $this;
    }

    /**
     * Выполнить загрузку всех необходимых скриптов
     *
     * @return $this
     */
    public function onReady()
    {
        if (!$this->_ajaxload) {
            $this->mainLoad()->speller();
            $this->_ajaxload = true;
        }
		
        $this->addHtml('<script>
            Ext.onReady(function() {
                ' . $this->getScript('main') . '
				' . $this->getScript('tv') . '
            });
        </script>');
        return $this;
    }

    /**
     * Полное имя настройки с учетом префикса компонента
     *
     * @param string $name ключ настройки
     * @param string $sep разделитель имени компонента и ключа настройки
     * @return string полное имя ключа настройки
     */
    protected function optName($name,$sep='.')
    {
        return is_scalar($name) ? implode($sep, array($this->_pkgName, $name)) : '';
    }

    /**
     * Индивидуальные настройки для редактора
     *
     * @param string $propName имя редактора для которого будут получаться настройки
     * @return string строка с настройками
     */
    protected function getSettings($propName)
    {
        if (!isset($this->_settings[$propName])) {
            $setting = (!empty($propName)) ? $this->getOption($this->optName('settings_' . $propName), null, '') : '';
            if (empty($setting)) {
                $this->_settings[$propName] = $this->_cfg['editorSettings'];
            } else {
                $this->_settings[$propName] = $setting;
            }
        }
        return $this->_settings[$propName];
    }

    /**
     * Объединение всех скриптов подготовленных для загрузки методом {@link collectScript}
     *
     * @param string $mode метод загрузки (основное поле или TV параметры)
     * @return string строка со всеми JS-скриптами подготовленными для загрузки
     */
    protected function getScript($mode = 'main')
    {
        $script = isset($this->_script[$mode]) ? $this->_script[$mode] : array();
        return implode("\r\n", $script);
    }

    /**
     * Предварительная сборка всех скриптов
     *
     * @param string $script имя скрипта
     * @param string $mode метод загрузки (основное поле или TV параметры)
     * @return $this
     */
    protected function collectScript($script, $mode = 'main')
    {
        if (!empty($script) && is_scalar($script)) {
            $script = trim($script);
            if (substr($script, -1, 1) != ';') {
                $script .= ';';
            }
            $this->_script[$mode][] = $script;
        }
        return $this;
    }

    /**
     * Преобразование массива в JSON строку
     *
     * @param array $array PHP массив
     * @return string JSON строка составленная из входного массива
     */
    private function toJson(array $array)
    {
        return $this->_modx->toJson($array);
    }

    /**
     * Выполняет загрузку лексикона в память
     *
     * @param $element Имя лексикона
     * @return $this
     */
    private function lexiconLoad($element)
    {
        $this->_modx->lexicon->load($element);
        return $this;
    }

    /**
     * Поиск значения по ключу в базе настроек
     *
     * @param string $key Имя параметра
     * @param array $options Набор опция для переопределения
     * @param mixed $default Значение по умолчанию, если ключа в базе нет или он пустой
     * @param bool $skipEmpty Метод восприятия пустых значений в базе
     * @return mixed Значение которое принадлежит параметру с искомым ключом
     */
    private function getOption($key, $options = null, $default = null, $skipEmpty = false)
    {
        return $this->_modx->getOption($key, $options, $default, $skipEmpty);
    }

    /**
     * Добавлние лексикона на страницу
     *
     * @param $element string имя лексикона
     * @return $this
     */
    private function addLexicon($element)
    {
        $this->_modx->controller->addLexiconTopic($element);
        return $this;
    }

    /**
     * Добавлине к загрузке CSS документа.
     * Выполняет роль прослойки для работы с $modx->controller->addCss();
     * Можно использовать $modx->RegClientCSS(), но тогда плагин не будет работать с AjaxManager
     *
     * @param $element string Ссылка на СЫЫ документ
     * @return $this
     */
    private function addCSS($element)
    {
        //$this->_modx->regClientCSS($element);
        $this->_modx->controller->addCss($element);
        return $this;
    }

    /**
     * Добавлине к загрузке JavaScript документа.
     * Выполняет роль прослойки для работы с $modx->controller->addJavascript();
     * Можно использовать $modx->regClientStartupScript(), но тогда плагин не будет работать с AjaxManager
     *
     * @param $element string Ссылка на JavaScript документ
     * @return $this
     */
    private function addJS($element)
    {
		if($this->_cfg['AjaxManager']){
			$this->_modx->controller->addJavascript($element);
		}else{
			$this->_modx->regClientStartupScript($element);
		}
        return $this;
    }

    /**
     * Внедрение HTML текста на страницу.
     * Выполняет роль прослойки для работы с $modx->controller->addHtml();
     * Можно использовать $modx->regClientHTMLBlock() с флагом true, но тогда плагин не будет работать с AjaxManager
     *
     * @param $element string блок с HTML текстом
     * @return $this
     */
    private function addHtml($element)
    {
        //$this->_modx->regClientHTMLBlock($element, true);
        $this->_modx->controller->addHtml($element);
        return $this;
    }
}