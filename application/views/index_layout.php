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
<link type="text/css" href="/media/css/index.css" rel="stylesheet" />
<!--[if IE 6]><script type="text/javascript" src="/media/js/iepngfix_tilebg.js"></script><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="/media/css/main_ie.css" media="all" /><![endif]-->
<script type="text/javascript" src="/media/js/jquery-1.4.1.min.js"></script>
</head>

<body>
<div id="layout">
 <div id="header">
  <div class="inner">
   <?php echo $header; ?>
      <?php echo ORM::factory('Block')->blocks('main_top'); ?>
  </div>
 </div>
    
<div id="buss">
  <div class="inner">
   <div id="layout_left"><img alt="states we serve" src="/media/img/we_serve.png" height="58" width="296" />
    <div id="menu_left">
	 <?php echo $navigation; ?>
	</div>
   </div>
    <div id="bus-in"><img src="/media/img/bigbus.png" width="460" height="" />
    <div id="intro"><img  src="/media/img/star.png" class="star" height="180" width="205" />
	 <div id="intro_content">
            <?php echo ORM::factory('Block')->blocks('main_center'); ?>
	 </div>
	</div>
   </div>
   <div id="bus-in2"><img  src="/media/img/smallbus.png" width="300" height="" />
    <div id="first_right">
            <?php echo ORM::factory('Block')->blocks('main_bottom'); ?>
	</div>
   </div>
   
  </div>
 </div>

<div id="footer-index">
  <div class="wrap">
   <?php echo $footer; ?>
   <div id="made_in">
    <div>Made by <a href="#">Digital media</a></div>
   </div>
  </div>
 </div>
</div>
</body>
</html>