<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div class="grid_4 alpha" style="margin-left:0;">
    <?php echo ORM::factory('Block')->blocks('main_left'); ?>
</div>

<div class="grid_9">
    <?php echo ORM::factory('Block')->blocks('main_center'); ?>
</div>

<div class="grid_3 omega" style="margin-right:0;">
    <?php echo ORM::factory('Block')->blocks('main_right'); ?>
</div>
