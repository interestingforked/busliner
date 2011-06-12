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
        <h4 onclick="tb(1)"><?php echo __('Language info'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('locale', __('Locale'), NULL, TRUE) ?>
                <?php echo Form::input('locale', $language->locale) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('title', __('Language'), NULL, TRUE) ?>
                <?php echo Form::input('title', $language->title) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('default', __('Default language')) ?>
                <?php echo Form::checkbox('default', 1, $language->default==1) ?>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>