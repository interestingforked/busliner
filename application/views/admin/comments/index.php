<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("a.view").fancybox({'titlePosition':'inside','transitionIn':'none','transitionOut':'none'});
});
</script>

<div id="content">
    <div class="block">
        <h4><?php echo __('Comments'); ?></h4>
        <div class="content">
            <?php if ($comments->count()) { ?>
            <table class="data">
                <tr>
                    <th><?php echo __('Module'); ?></th>
                    <th><?php echo __('Name'); ?></th>
                    <th><?php echo __('E-mail'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th><?php echo __('IP address'); ?></th>
                    <th><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($comments AS $comment) { ?>
                <tr>
                    <td><?php echo strtoupper($comment->module); ?></td>
                    <td><?php echo $comment->name; ?></td>
                    <td><?php echo $comment->email; ?></td>
                    <td><?php echo $comment->created; ?></td>
                    <td><?php echo $comment->ip_address; ?></td>
                    <td class="actions"><?php
                        echo HTML::anchor('admin/ajax/viewcomment/'.$comment->id, __('View'), array('class' => 'view'));
                        echo HTML::anchor('admin/comments/approve/'.$comment->id, __('Approve'));
                        echo HTML::anchor('admin/comments/delete/'.$comment->id, __('Delete'));
                    ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php echo $page_links; ?>
            <?php
            } else {
                echo HTML::flash_message(__('No comments found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>