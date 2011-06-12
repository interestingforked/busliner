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
        <h4 onclick="tb(1)"><?php echo __('Settings'); ?><span></span></h4>
        <div class="content" id="block1">
            <?php foreach ($settings AS $setting): ?>
            <div class="form-row-long">
                <?php echo Form::label($setting->key, $setting->name); ?>
                <?php 
                switch ($setting->type) {
                    case 'input':
                        echo Form::input($setting->key, $setting->value); 
                        break;
                    case 'textarea':
                        echo Form::textarea($setting->key, $setting->value); 
                        break;
                    case 'checkbox':
                        echo Form::checkbox($setting->key, 1, $setting->value == 1); 
                        break;
                }
                
                ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>