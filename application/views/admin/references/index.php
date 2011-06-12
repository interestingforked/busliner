<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("a.view").fancybox({'titlePosition':'inside','transitionIn':'none','transitionOut':'none'});
});
</script>

<div id="content">
    <div class="block">
        <h4><?php echo __('References'); ?></h4>
        <div class="content">
            <?php if ($references->count()) { ?>
            <table class="data">
                <tr>
                    <th><?php echo __('Name'); ?></th>
                    <th><?php echo __('E-mail'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th><?php echo __('IP address'); ?></th>
                    <th><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($references AS $reference) { ?>
                <tr>
                    <td><?php echo $reference->name; ?></td>
                    <td><?php echo $reference->e_mail; ?></td>
                    <td><?php echo $reference->created; ?></td>
                    <td><?php echo $reference->ip; ?></td>
                    <td class="actions"><?php
                        echo HTML::anchor('admin/references/view/'.$reference->id, __('View'));
                        echo HTML::anchor('admin/references/edit/'.$reference->id, __('Edit'));
                        echo HTML::anchor('admin/references/approve/'.$reference->id, __('Approve'));
                        echo HTML::anchor('admin/references/delete/'.$reference->id, __('Delete'));
                    ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php echo $page_links; ?>
            <?php
            } else {
                echo HTML::flash_message(__('No references found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>