<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div class="content">
    <h1>Карта сайта</h1>
    <div class="sitemap">
    <?php
    ORM::factory('Page')->display_children(0,0,$language);
    ?>
    </div>
</div>