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
        <h4 onclick="tb(1)"><?php echo __('Edit block'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('title', __('Title'), NULL, TRUE) ?>
                <?php echo Form::input('title', $block->title) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('show_title', __('Show title')) ?>
                <?php echo Form::checkbox('show_title', 1, ($block->show_title==1)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('type', __('Block type'), NULL, TRUE) ?>
                <?php echo Form::select('type', $types, $block->type) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('plugin', __('Plugin')) ?>
                <?php echo Form::select('plugin', $plugins, $block->plugin) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('language_id', __('Language'), NULL, TRUE) ?>
                <?php echo Form::select('language_id', $languages, $block->language_id) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('position', __('Position')) ?>
                <?php echo Form::input('position', $block->position) ?>
                (jāievada 1, 2, 3 utt.)
            </div>
        </div>
    </div>
    <div class="block">
        <h4 onclick="tb(2)"><?php echo __('Block content'); ?><span></span></h4>
        <div class="content" id="block2">
            <div class="form-row-long">
                <?php echo Form::textarea('body', ((empty($block->content))?'<p>'.$block->content.'</p>':$block->content), array('class' => 'editor')) ?>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>
