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
        <h4 onclick="tb(1)"><?php echo __('Category info'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('title', __('Category'), NULL, TRUE) ?>
                <?php echo Form::input('title', $category->title) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('show', __('Show in menu')) ?>
                <?php echo Form::checkbox('show', 1, ($category->show==1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('slug', __('Category slug')) ?>
                <?php echo Form::input('slug', $category->slug) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('rss_link', __('RSS link')) ?>
                <?php echo Form::input('rss_link', $category->rss_link, array('size' => 40)) ?>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>