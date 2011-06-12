<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<?php foreach ($meta AS $tag_name => $tag_content) { ?>
<meta name="<?php echo $tag_name; ?>" content="<?php echo $tag_content; ?>" />
<?php } ?>
<link type="text/css" href="/media/css/style.css" rel="stylesheet" />
<!--[if IE 6]><script type="text/javascript" src="/media/js/iepngfix_tilebg.js"></script><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="/media/css/main_ie.css" media="all" /><![endif]-->
<script type="text/javascript" src="/media/js/rc.js"></script>
<script type="text/javascript" src="/media/js/jquery-1.4.1.min.js"></script>
</head>

<body>
<div id="layout">
 <div id="header">
  <div class="inner">
   <?php echo $header; ?>
   <div id="menu">
    <?php echo $breadcrumbs; ?>
   </div>
  </div>
 </div>
    
<div id="page-body">
  <div id="page-body-inner">
   <div id="layout_left">
    <?php echo $navigation; ?>
   </div>    
    
     <div id="layout_middle">
    <div id="content">
        <?php echo $content; ?>
    </div>
   </div>
   
   <div id="layout_right">
       <?php echo $sidebar; ?>
   </div>

<div id="footer">
  <div class="wrap">
   <?php echo $footer; ?>
  </div>
 </div>
</div>
</body>
</html>