<?php
if ($modx->event->name == 'OnRichTextEditorRegister') {
    $modx->event->output('MarkitUp!');
    return;
}
if(!$modx->getOption('use_editor',false)) return;

switch($modx->event->name){
    case 'OnRichTextEditorInit':{
        $editor = $modx->getOption('which_editor',null,$modx->event->params['editor']);
        if($editor==='MarkitUp!' && is_object($scriptProperties['resource']) && $scriptProperties['resource']->get('richtext')){
            $markitup = $modx->getService(
                'markitup',
                'MarkitUp',
                $modx->getOption('markitup.core_path',null,$modx->getOption('core_path').'components/markitup/')
            );
            foreach($scriptProperties['elements'] as $item){
                $markitup->showEditor('#'.$item,'main');
            }

            /*
             * Для всех ТВшек можно так. Но у нас могут быть индивидуальные настройки на каждой ТВшке
             * $markitup->showEditor('.modx-richtext','tv');
             */
            if(method_exists($scriptProperties['resource'],'getTemplateVars')){
                $TVs=$scriptProperties['resource']->getTemplateVars();
                foreach($TVs as $TV){
                    if('richtext'==$TV->get('type')){
                        $markitup->showEditor('#tv'.$TV->get('id'), 'tv');
                    }
                }
            }
            $markitup->onReady();
        }
        break;
    }
}