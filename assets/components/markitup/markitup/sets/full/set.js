{
    nameSpace : "resourceEditor",
        onShiftEnter : {
        keepDefault : false,
        replaceWith : '<br />\n'
    },
    onCtrlEnter : {
        keepDefault : false,
        openWith : '\n<p>',
        closeWith : '</p>\n'
    },
    onTab : {
        keepDefault : false,
        openWith : '     '
    },
    markupSet : [{
        name : _('markitup.modx_tag'),
        className : 'modx',
        dropMenu : [{
            name : _('markitup.modx_tag_id'),
            className : 'modx-id',
            replaceWith : '[[*id]]'
        }, {
            name : _('markitup.modx_tag_link'),
            className : 'modx-link',
            openWith : '[[~',
            closeWith : ']]',
            placeHolder : ''
        }, {
            name : _('markitup.modx_tag_pagetitle'),
            className : 'modx-pagetitle',
            replaceWith : '[[*pagetitle]]'
        }, {
            name : _('markitup.modx_tag_longtitle'),
            className : 'modx-longtitle',
            replaceWith : '[[*longtitle]]'
        }, {
            name : _('markitup.modx_tag_assets_url'),
            className : 'modx-assets',
            replaceWith : '[[++assets_url]]'
        }, {
            name : _('markitup.modx_tag_sitename'),
            className : 'modx-sitename',
            replaceWith : '[[++site_name]]'
        }, ]
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.tag_p'),
        className : 'paragraph',
        key: 'P',
        openWith : '<p(!( class="[![Class]!]")!)>',
        closeWith : '</p>'
    }, {
        name : _('markitup.tag_strong'),
        key : 'B',
        className : 'bold',
        openWith : '<strong>',
        closeWith : '</strong>'
    }, {
        name : _('markitup.tag_em'),
        className : 'italic',
        openWith : '<em>',
        closeWith : '</em>'
    }, {
        name : _('markitup.tag_s'),
        className : 'stroke',
        openWith : '<s>',
        closeWith : '</s>'
    }, {
        name : _('markitup.tag_u'),
        className : 'underline',
        openWith : '<u>',
        closeWith : '</u>'
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.tag_img'),
        key : 'I',
        className : 'image',
        replaceWith : '<img src="[![' + _('markitup.alert_link') + ':!:http://]!]" alt="[![' + _('markitup.alert_description') + ']!]" />'
    }, {
        name : _('markitup.tag_a'),
        key : 'L',
        className : 'link',
        openWith : '<a href="[![' + _('markitup.alert_link') + ':!:http://]!]"(!( title="[![' + _('markitup.alert_description') + ']!]")!)>',
        closeWith : '</a>',
        placeHolder : ''
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.tag_h1'),
        key : '1',
        className : 'h1',
        openWith : '<h1(!( class="[![Class]!]")!)>',
        closeWith : '</h1>',
        placeHolder : ''
    }, {
        name : _('markitup.tag_h2'),
        key : '2',
        className : 'h2',
        openWith : '<h2(!( class="[![Class]!]")!)>',
        closeWith : '</h2>',
        placeHolder : ''
    }, {
        name : _('markitup.tag_h3'),
        key : '3',
        className : 'h3',
        openWith : '<h3(!( class="[![Class]!]")!)>',
        closeWith : '</h3>',
        placeHolder : ''
    }, {
        name : _('markitup.tag_h4'),
        key : '4',
        className : 'h4',
        openWith : '<h4(!( class="[![Class]!]")!)>',
        closeWith : '</h4>',
        placeHolder : ''
    }, {
        name : _('markitup.tag_h5'),
        key : '5',
        className : 'h5',
        openWith : '<h5(!( class="[![Class]!]")!)>',
        closeWith : '</h5>',
        placeHolder : ''
    }, {
        name : _('markitup.tag_h6'),
        key : '6',
        className : 'h6',
        openWith : '<h6(!( class="[![Class]!]")!)>',
        closeWith : '</h6>',
        placeHolder : ''
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.tag_blockquote'),
        className : 'quote',
        openWith : '<blockquote>',
        closeWith : '</blockquote>'
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.tag_code'),
        className : 'code',
        openWith : '<code>',
        closeWith : '</code>'
    }, {
        name : _('markitup.callback_encodechars'),
        className : "encodechars",
        replaceWith : function (markItUp) {
            var container = document.createElement('div');
            container.appendChild(document.createTextNode(markItUp.selection));
            return container.innerHTML;
        }
    }, {
        name : _('markitup.callback_clean'),
        className : 'clean',
        replaceWith : function (h) {
            return h.selection.replace(/<(.*?)>/g, "")
        }
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.callback_createtable'),
        className : 'tablegenerator',
        placeholder : "",
        replaceWith : function (markItUp) {
            var cols = prompt(_('markitup.callback_createtable_cols')),
                rows = prompt(_('markitup.callback_createtable_rows')),
                html = "<table>\n";
            if (markItUp.altKey) {
                html += " <tr>\n";
                for (var c = 0; c < cols; c++) {
                    html += "! [![TH" + (c + 1) + " text:]!]\n";
                }
                html += " </tr>\n";
            }
            for (var r = 0; r < rows; r++) {
                html += " <tr>\n";
                for (var c = 0; c < cols; c++) {
                    html += "  <td>" + (markItUp.placeholder || "") + "</td>\n";
                }
                html += " </tr>\n";
            }
            html += "<table>\n";
            return html;
        }
    }, {
        name : _('markitup.tag_table'),
        openWith : '<table>',
        closeWith : '</table>',
        placeHolder : "<tr><(!(td|!|th)!)></(!(td|!|th)!)></tr>",
        className : 'table'
    }, {
        name : _('markitup.tag_tr'),
        openWith : '<tr>',
        closeWith : '</tr>',
        placeHolder : "<(!(td|!|th)!)></(!(td|!|th)!)>",
        className : 'table-col'
    }, {
        name : _('markitup.tag_td'),
        openWith : '<(!(td|!|th)!)>',
        closeWith : '</(!(td|!|th)!)>',
        className : 'table-row'
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.tag_ul'),
        className : 'ul',
        openWith : '<ul>\n',
        closeWith : '</ul>\n'
    }, {
        name : _('markitup.tag_ol'),
        className : 'ol',
        openWith : '<ol>\n',
        closeWith : '</ol>\n'
    }, {
        name : _('markitup.tag_li'),
        className : 'li',
        openWith : '<li>',
        closeWith : '</li>'
    }, {
        separator : '---------------'
    }, {
        name : _('markitup.tag_style'),
        openWith : '<style>\n',
        closeWith : '\n</style>',
        className : 'css'
    }, {
        name : _('markitup.css_class'),
        className : 'class',
        placeHolder : '',
        openWith : '.[![Class name]!] {\n',
        closeWith : '\n}'
    }, {
        name : _('markitup.css_align'),
        className : 'alignments',
        dropMenu : [{
            name : _('markitup.css_align_left'),
            className : 'left',
            replaceWith : 'text-align:left;'
        }, {
            name : _('markitup.css_align_center'),
            className : 'center',
            replaceWith : 'text-align:center;'
        }, {
            name : _('markitup.css_align_right'),
            className : 'right',
            replaceWith : 'text-align:right;'
        }, {
            name : _('markitup.css_align_justify'),
            className : 'justify',
            replaceWith : 'text-align:justify;'
        }
        ]
    }, {
        name : _('markitup.css_padding'),
        className : 'padding',
        dropMenu : [{
            name : _('markitup.css_padding_top'),
            className : 'top',
            openWith : '(!(padding|!|margin)!)-top:',
            placeHolder : '5px',
            closeWith : ';'
        }, {
            name : _('markitup.css_padding_left'),
            className : 'left',
            openWith : '(!(padding|!|margin)!)-left:',
            placeHolder : '5px',
            closeWith : ';'
        }, {
            name : _('markitup.css_padding_right'),
            className : 'right',
            openWith : '(!(padding|!|margin)!)-right:',
            placeHolder : '5px',
            closeWith : ';'
        }, {
            name : _('markitup.css_padding_bottom'),
            className : 'bottom',
            openWith : '(!(padding|!|margin)!)-bottom:',
            placeHolder : '5px',
            closeWith : ';'
        }
        ]
    }, {
        separator : '---------------'
    }, {
        name : _('speller_check'),
        afterInsert : function (h) {
            speller.check([h.textarea]);
        },
        className : 'spelling'
    }, {
        name : _('markitup.speller_options'),
        afterInsert : function (h) {
            speller.optionsDialog();
        },
        className : 'spellingoptions'
    }
    ]
}