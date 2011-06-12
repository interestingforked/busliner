<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <div class="block">
        <h4><?php echo __('Roles'); ?></h4>
        <div class="content">
            <?php if ($roles->count()) { ?>
            <ul class="list">
                <?php foreach ($roles AS $role) { ?>
                <li>
                    <span class="border"></span>
                    <?php echo $role->name; ?>
                    <div class="actions">
                        <?php
                        echo HTML::anchor('admin/roles/edit/'.$role->id, HTML::image('media/img/admin/page_edit.png'), array('title' => __('Edit')));
                        echo HTML::anchor('admin/roles/delete/'.$role->id, HTML::image('media/img/admin/page_delete.png'),
                                array('onclick' => 'return confirm("'.__('Are you sure you want to delete this role?').'")', 'title' => __('Delete')));
                        ?>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No roles found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>