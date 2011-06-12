<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content-login">
    <div class="header">
        <a href="/admin"><?php echo __('Administration'); ?></a>
    </div>
    <div class="login">
        <?php
        if (!empty($errors)) {
            echo HTML::flash_message($errors);
        }
        ?>
        <?php echo Form::open(); ?>
        <div class="form-row">
            <?php echo Form::label('username', __('Username')); ?>
            <?php echo Form::input('username', NULL); ?>
        </div>
        <div class="form-row">
            <?php echo Form::label('password', __('Password')); ?>
            <?php echo Form::password('password', NULL); ?>
        </div>
        <div class="submit-row">
            <?php echo Form::submit('submit', __('Log in')); ?>
        </div>
        <?php echo Form::close(); ?>
    </div>
</div>