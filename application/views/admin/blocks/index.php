<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <div class="block">
        <h4><?php echo __('Blocks'); ?></h4>
        <div class="content">
            <?php if ($blocks->count()) { ?>
            <ul class="list">
                <?php foreach ($blocks AS $block) { ?>
                <li>
                    <span class="border"></span>
                    <?php
                    if ($block->type) {
                        echo Kohana::config('application')->block_types[$block->type].' - ';
                    }
                    echo $block->title;
                    ?>
                    <div class="actions">
                        <?php
                        echo HTML::anchor('admin/blocks/status/'.$block->id,
                            HTML::image(($block->active) ? 'media/img/admin/tick.png' : 'media/img/admin/cross.png' ), array('title' => __('Change status')));
                        echo HTML::anchor('admin/blocks/edit/'.$block->id, HTML::image('media/img/admin/page_edit.png'), array('title' => __('Edit')));
                        echo HTML::anchor('admin/blocks/moveup/'.$block->id, HTML::image('media/img/admin/arrow_up.png'), array('title' => __('Move up')));
                        echo HTML::anchor('admin/blocks/movedown/'.$block->id, HTML::image('media/img/admin/arrow_down.png'), array('title' => __('Move down')));
                        echo HTML::anchor('admin/blocks/delete/'.$block->id, HTML::image('media/img/admin/page_delete.png'),
                                array('onclick' => 'return confirm("'.__('Are you sure you want to delete this block?').'")', 'title' => __('Delete')));
                        ?>
                    </div>
                    <div class="actions">
                        <?php
                        if ($block->language_id > 0) {
                            echo ORM::factory('Language')->get_locale_by_id($block->language_id);
                        } else {
                            echo __('All');
                        }
                        ?>
                    </div>
                    <div class="actions">
                        <?php
                        if ($block->plugin) {
                            echo Kohana::config('application')->plugins[$block->plugin];
                        } else {
                            echo __('Blocks');
                        }
                        ?>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No blocks found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>