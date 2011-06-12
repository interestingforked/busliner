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
        <link rel="stylesheet" type="text/css" href="/media/css/login.css" media="screen" />
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="/media/css/ie6.css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" href="/media/css/ie.css" media="screen" /><![endif]-->
    </head>
    <body id="login">
        <div class="container_16">
            <div class="grid_16">
                <?php echo $content; ?>
            </div>
            <div class="clear"></div>
        </div>
    </body>
</html>