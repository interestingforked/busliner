<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <div class="block">
        <h4><?php echo __('Languages'); ?></h4>
        <div class="content">
            <?php if ($languages->count()) { ?>
            <ul class="list">
                <?php foreach ($languages AS $language) { ?>
                <li>
                    <span class="border"></span>
                    <?php echo $language->title; ?>
                    <div class="actions">
                        <?php
						echo HTML::anchor('admin/languages/show/'.$language->id,
                            HTML::image(($language->show == 1) ? 'media/img/admin/tick.png' : 'media/img/admin/cross.png' ), array('title' => __('Show in menu')));
                        echo HTML::anchor('admin/languages/edit/'.$language->id, HTML::image('media/img/admin/page_edit.png'), array('title' => __('Edit')));
                        echo HTML::anchor('admin/languages/moveup/'.$language->id, HTML::image('media/img/admin/arrow_up.png'), array('title' => __('Move up')));
                        echo HTML::anchor('admin/languages/movedown/'.$language->id, HTML::image('media/img/admin/arrow_down.png'), array('title' => __('Move down')));
                        echo HTML::anchor('admin/languages/delete/'.$language->id, HTML::image('media/img/admin/page_delete.png'),
                                array('onclick' => 'return confirm("'.__('Are you sure you want to delete this language?').'")', 'title' => __('Delete')));
                        ?>
                    </div>
                    <?php if ($language->default) { ?>
                    <div class="actions">
                        <?php echo __('default'); ?>
                    </div>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No languages found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>