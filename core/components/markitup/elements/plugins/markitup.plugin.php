<?php

switch ($modx->event->name) {
    /**
     * Регистрация редактора для настроек со списком доступных редакторов
     */
    case 'OnRichTextEditorRegister':{
        $modx->event->output('MarkitUp!');
        break;
    }
    /**
     * Инициализация загрузки редактора
     */
    case 'OnRichTextEditorInit':
    {
        /**
         * Использование редакторов отключено в настройках движка
         */
        if (!$modx->getOption('use_editor', false)) return;

        /**
         * Редактор для этого документа
         */
        $editor = $modx->getOption('which_editor', null, $modx->event->params['editor']);

        /**
         * выбран редактор отличный от MarkitUp или вообще для текущего документа отключены редакторы
         */
        if ($editor === 'MarkitUp!' && is_object($scriptProperties['resource']) && $scriptProperties['resource']->get('richtext')) {
            $markitup = $modx->getService(
                'markitup',
                'MarkitUp',
                $modx->getOption('markitup.core_path', null, $modx->getOption('core_path') . 'components/markitup/')
            );
            foreach ($scriptProperties['elements'] as $item) {
                $markitup->showEditor('#' . $item, 'main');
            }

            /**
             * Для всех ТВшек можно так. Но у нас могут быть индивидуальные настройки на каждой ТВшке
             * $markitup->showEditor('.modx-richtext','tv');
             */
            if (method_exists($scriptProperties['resource'], 'getTemplateVars')) {
                $TVs = $scriptProperties['resource']->getTemplateVars();
                foreach ($TVs as $TV) {
                    if ('richtext' == $TV->get('type')) {
                        $markitup->showEditor('#tv' . $TV->get('id'), 'tv');
                    }
                }
            }

            /**
             * Загрузка скриптов
             */
            $markitup->onReady();
        }
        break;
    }
}