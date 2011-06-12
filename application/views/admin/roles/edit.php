<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <?php echo Form::open(); ?>
    <div class="form-action">
        <?php echo Form::submit('submit', __('Save')); ?>
    </div>
    <?php
        if (!empty($errors)) {
            echo HTML::flash_message($errors);
            echo '<br/>';
        }
    ?>
    <div class="block">
        <h4 onclick="tb(1)"><?php echo __('Role info'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('name', __('Name'), NULL, TRUE) ?>
                <?php echo Form::input('name', $role->name) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('description', __('Description')) ?>
                <?php echo Form::textarea('description', $role->description) ?>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>