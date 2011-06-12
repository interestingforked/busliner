<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="/media/css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/media/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/media/css/960fluid.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/media/css/base.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/media/css/admin.css" media="screen" />

        <link rel="stylesheet" type="text/css" href="/media/js/ui-themes/smoothness/jquery-ui-1.7.3.custom.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/media/css/elfinder.css" media="screen" /> 

        <script src="/media/js/jquery-1.4.1.min.js" type="text/javascript"></script>
        <script src="/media/js/jquery-ui-1.7.3.custom.min.js" type="text/javascript"></script>
        <script src="/media/js/datepicker.i18n.lv.js" type="text/javascript"></script>
        <script src="/media/js/elfinder.min.js" type="text/javascript"></script>

        <link rel="stylesheet" type="text/css" href="/media/css/fileuploader.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/media/css/jquery.fancybox-1.3.1.css" media="screen" />
        <script src="/media/js/jquery.mousewheel-3.0.2.pack.js" type="text/javascript"></script>
        <script src="/media/js/jquery.fancybox-1.3.1.js" type="text/javascript"></script>
        <script src="/media/js/admin.js" type="text/javascript"></script>

        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="/media/css/ie6.css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" href="/media/css/ie.css" media="screen" /><![endif]-->

        <script type="text/javascript" src="/media/js/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
        tinyMCE.init({
            mode : "textareas",
            elements : 'abshosturls',
            theme : "advanced",
            relative_urls : false,
            remove_script_host : true,
            editor_selector : "editor",
            editor_deselector : "content",
            plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

            theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,

            extended_valid_elements : "iframe[src|class|width|height|name|align]",

            content_css : "/media/css/style_text.css",
            
            file_browser_callback: function(field_name, url, type, win) {
                aFieldName = field_name, aWin = win;
                if($('#elfinder').length == 0) {
                    $('body').append($('<div/>').attr('id', 'elfinder'));
                    $('#elfinder').elfinder({
                        url : '/vendor/connector.php',
                        lang: 'lv',
                        dialog : { width: 700, modal: true, title: 'Files', zIndex: 400001 }, // open in dialog window
                        editorCallback: function(url) {
                            aWin.document.forms[0].elements[aFieldName].value = url;
                            if (typeof(win.ImageDialog) != "undefined") {
                                if (aWin.ImageDialog.getImageData) aWin.ImageDialog.getImageData();
                                if (aWin.ImageDialog.showPreviewImage) aWin.ImageDialog.showPreviewImage(url);
                            }
                        },
                        closeOnEditorCallback: true
                    });
                } else {
                    $('#elfinder').elfinder('open');
                }
            },
            template_replace_values : {
                username : "orderman",
                staffid : "812254"
            }
        });
        </script>
        
    </head>
    <body>
        <div class="container_16">
            <div class="grid_16" id="header">
                <?php echo $header; ?>
            </div>
            <div class="clear"></div>
            <div class="grid_16" id="nav">
                <?php echo $navigation; ?>
            </div>
            <div class="clear"></div>
            <div class="grid_16" id="breadcrumbs">
                <?php echo $breadcrumbs; ?>
            </div>
            <div class="clear"></div>

            <?php if ($wide) { ?>
            <div class="grid_16">
                <?php echo $content; ?>
            </div>

            <?php } else { ?>
            <div class="grid_3" id="navbar">
                <?php echo $sidebar; ?>
            </div>
            <div class="grid_13">
                <?php echo $content; ?>
            </div>
            <?php } ?>

            <div class="clear"></div>
            <div class="grid_16" id="footer">
                <?php echo $footer; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="container_16" id="profiler-stat">
            <div class="grid_16">
                <?php //echo View::factory('profiler/stats'); ?>
            </div>
        </div>
    </body>
</html>
