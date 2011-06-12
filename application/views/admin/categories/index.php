<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <div class="block">
        <h4><?php echo __('Categories'); ?></h4>
        <div class="content">
            <?php if ($categories->count()) { ?>
            <ul class="list">
                <?php foreach ($categories AS $category) { ?>
                <li>
                    <span class="border"></span>
                    <?php echo $category->title; ?>
                    <div class="actions">
                        <?php
                        echo HTML::anchor('admin/categories/show/'.$category->id,
                            HTML::image(($category->show == 1) ? 'media/img/admin/tick.png' : 'media/img/admin/cross.png' ), array('title' => __('Show in menu')));
                        echo HTML::anchor('admin/categories/edit/'.$category->id, HTML::image('media/img/admin/page_edit.png'), array('title' => __('Edit')));
                        echo HTML::anchor('admin/categories/delete/'.$category->id, HTML::image('media/img/admin/page_delete.png'),
                                array('onclick' => 'return confirm("'.__('Are you sure you want to delete this category?').'")', 'title' => __('Delete')));
                        ?>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No categories found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>