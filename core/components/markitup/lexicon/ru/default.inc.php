<?php
/**
 * Russian lexicon for MarkitUp!
 *
 * @package markitup
 * @subpackage lexicon
 */

$_lang['markitup'] = 'MarkitUp!';

$_lang['markitup.modx_tag'] = 'MODX Теги';
$_lang['markitup.modx_tag_id'] = 'ID документа';
$_lang['markitup.modx_tag_link'] = 'Ссылка';
$_lang['markitup.description'] = 'Описание';
$_lang['markitup.modx_tag_pagetitle'] = 'Заголовок';
$_lang['markitup.modx_tag_longtitle'] = 'Расширенный заголовок';
$_lang['markitup.modx_tag_assets_url'] = 'Папка assets';
$_lang['markitup.modx_tag_sitename'] = 'Название сайта';
$_lang['markitup.tag_p'] = 'Абзац';
$_lang['markitup.tag_strong'] = 'Жирный';
$_lang['markitup.tag_em'] = 'Курсив';
$_lang['markitup.tag_s'] = 'Зачеркнутый';
$_lang['markitup.tag_u'] = 'Подчеркнутый';
$_lang['markitup.tag_h1'] = 'Заголовок H1';
$_lang['markitup.tag_h2'] = 'Заголовок H2';
$_lang['markitup.tag_h3'] = 'Заголовок H3';
$_lang['markitup.tag_h4'] = 'Заголовок H4';
$_lang['markitup.tag_h5'] = 'Заголовок H5';
$_lang['markitup.tag_h6'] = 'Заголовок H6';
$_lang['markitup.tag_blockquote'] = 'Цитата';
$_lang['markitup.tag_code'] = 'Код';
$_lang['markitup.tag_img'] = 'Картинка';
$_lang['markitup.tag_a'] = 'Ссылка';
$_lang['markitup.alert_link'] = 'Ссылка';
$_lang['markitup.alert_description'] = 'Описание';
$_lang['markitup.callback_encodechars'] = 'Преобразовать HTML теги';
$_lang['markitup.callback_clean'] = 'Удалить все теги';
$_lang['markitup.callback_createtable'] = 'Создать таблицу';
$_lang['markitup.callback_createtable_cols'] = 'Число колонок';
$_lang['markitup.callback_createtable_rows'] = 'Число строк';
$_lang['markitup.tag_table'] = 'Обернуть в таблицу';
$_lang['markitup.tag_tr'] = 'Добавить строку';
$_lang['markitup.tag_td'] = 'Добавить ячейку';
$_lang['markitup.tag_ul'] = 'Маркированный список (ul)';
$_lang['markitup.tag_ol'] = 'Нумерованный список (ol)';
$_lang['markitup.tag_li'] = 'Элемент списка';
$_lang['markitup.tag_style'] = 'Стиль';
$_lang['markitup.css_class'] = 'Класс';
$_lang['markitup.css_align'] = 'Выравнивание';
$_lang['markitup.css_align_left'] = 'Выравнивание по левому краю';
$_lang['markitup.css_align_center'] = 'Выравнивание по центру';
$_lang['markitup.css_align_right'] = 'Выравнивание по правому краю';
$_lang['markitup.css_align_justify'] = 'Выравнивание по ширине';
$_lang['markitup.speller_check'] = 'Проверить орфографию';
$_lang['markitup.speller_options'] = 'Настройки проверки орфографии';
$_lang['markitup.css_padding'] = 'Отступ';
$_lang['markitup.css_padding_top'] = 'Отступ сверху';
$_lang['markitup.css_padding_left'] = 'Отступ слева';
$_lang['markitup.css_padding_right'] = 'Отступ справа';
$_lang['markitup.css_padding_bottom'] = 'Отступ снизу';

$_lang['setting_markitup.core_path'] = 'Путь к папке с back-end MarkitUp!';
$_lang['setting_markitup.core_path_desc'] = 'Путь к папке с ядром компонента MarkitUp!';
$_lang['setting_markitup.assets_url'] = 'Путь к папке с front-end MarkitUp!';
$_lang['setting_markitup.assets_url_desc'] = 'Путь к папке с в которой расположены основные js скрипты MarkitUp!';
$_lang['setting_markitup.settings'] = 'Настройки по умолчанию для всех RichText полей';
$_lang['setting_markitup.settings_desc'] = 'Эти настройки будут использоваться если не заданы индивидуальные правила для полей';
$_lang['setting_markitup.skin'] = 'Шаблон оформления редактора';
$_lang['setting_markitup.skin_desc'] = 'По умолчанию используется MODX. Если есть желание, то можно создать свой шаблон. Для этого в папке markitup/skins/ необходимо создать еще одну папку по аналогии с другими шаблонами и указать имя этой папки в значении данного параметра.';
$_lang['setting_markitup.jquery'] = 'Источник jQuery';
$_lang['setting_markitup.jquery_desc'] = 'Ссылка на библиотеку jQuery. Можно использовать CDN, но лучше подгружать локально указывая путь к файлу относительно корня сайта';
$_lang['setting_markitup.editorjs'] = 'JavaScript библиотека с MarkitUp!';
$_lang['setting_markitup.editorjs_desc'] = 'Можно поменять местоположение основной библиотеки и подгружать ее, например, с CDN';
$_lang['setting_markitup.css_button'] = 'Файл со стилями для кнопок';
$_lang['setting_markitup.css_button_desc'] = 'Если появится необходимость поменять картинку у кнопок или добавить новый стиль, то лучше всего это делать изменив путь к файлу, а не редактируя оригинальный';
$_lang['setting_markitup.custom_js'] = 'Дополнительные скрипты';
$_lang['setting_markitup.custom_js_desc'] = 'Кнопки редактора могут инициализировать вызов некоторых функций. Но предварительно эти функции нужно добавить на страницу. Сделать это можно при помощи этого параметра, перечислив пути к необходимым скриптам используя разделитель в виде тройной решетки: ###. При необходимости можно тут описать функции предварительно обернув ее в тег <script></script>';
$_lang['setting_markitup.speller_disable'] = 'Отключить проверку орфографии?';
$_lang['setting_markitup.speller_disable_desc'] = 'Включение данного параметра позволяет отключить загрузку скриптов для проверки орфографии. Это полезно, когда у вас страница с редактором слишком тяжелая, а проверка орфографии не используется. Обратите внимание, что данная опция не удаляет кнопку. Она лишь отключает загрузку скриптов отвечающих за проверку орфографии на стороне Yandex.';
$_lang['setting_markitup.spellerJS'] = 'Путь к скрипту Yandex.Speller';
$_lang['setting_markitup.spellerJS_desc'] = 'По умолчанию данный скрипт подгружается из локальной веб-папки компонента MarkitUp! Но можно указать загрузку с CDN. Например, с самого яндекса.';
$_lang['setting_markitup.speller_options'] = 'Настройки проверки орфографии по умолчанию';
$_lang['setting_markitup.speller_options_desc'] = 'По умолчанию определено игнорирование ссылок и подсвечивание слов идущих подряд. Можно задать другие настройки. Для этого необходимо перечислить константы используя разделитель + (плюс)';
$_lang['setting_markitup.speller_lang'] = 'Язык проверки орфографии';
$_lang['setting_markitup.speller_lang_desc'] = 'По умолчанию используется текущие установки MODX Revolution, но можно и принудительно указать. Поддерживаются следующие языки: ru - русский, uk - украинский, en - английски. Обратите внимание, что сам интерфейс системы проверки орфографии при этом не меняет свою языковую раскладку.';
$_lang['setting_markitup.settings_ta'] = 'Настройки для основного редактора';
$_lang['setting_markitup.settings_ta_desc'] = 'Настройки основного редактора документа. Для TV-параметров необходимо создать параметр markitup.settings_tv№. Где № это ID вашего TV параметра';
$_lang['setting_markitup.AjaxManager'] = 'Объединять все JavaScript файлы в один файл';
$_lang['setting_markitup.AjaxManager_desc'] = 'Объединяет все JavaScript файлы в один файл';
$_lang['setting_markitup.loadJquery'] = 'Загружать библиотеку jQuery?';
$_lang['setting_markitup.loadJquery_desc'] = 'Позволяет отключить загрузку jQuery библиотеки';