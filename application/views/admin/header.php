<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div class="user">
    <?php echo __('User'); ?>: <span><?php echo $user->username; ?> (<?php echo $user->get_fullname($user->id); ?>)</span><br/>
    <?php echo __('User roles'); ?>: <span><?php echo Arr::obj_to_str($user->roles->find_all(), array('name')); ?></span><br/>
    <?php echo HTML::anchor('admin/logout', __('Logout'), array('class' => 'logout')); ?>
</div>
<h1>
    <a href="/admin"><?php echo __('Administration'); ?></a>
</h1>