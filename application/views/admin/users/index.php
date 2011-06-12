<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("a.view").fancybox({'scrolling':'no','transitionIn':'none','transitionOut':'none'});
});
</script>

<div id="content">
    <div class="block">
        <h4><?php echo __('Users'); ?></h4>
        <div class="content">
            <?php if ($users->count()) { ?>
            <table class="data">
                <tr>
                    <th><?php echo __('Username'); ?></th>
                    <th><?php echo __('Display name'); ?></th>
                    <th><?php echo __('Firstname, lastname'); ?></th>
                    <th><?php echo __('E-mail'); ?></th>
                    <th><?php echo __('Last login'); ?></th>
                    <th><?php echo __('Actions'); ?></th>
                </tr>
                <?php 
                foreach ($users AS $user) {
                    $profile = $user->profiles->where('user_id','=',$user->id)->find();
                ?>
                <tr>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo $profile->display_name; ?></td>
                    <td><?php echo $profile->first_name.' '.$profile->last_name; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo date("Y-m-d G:i:s", $user->last_login); ?></td>
                    <td class="actions"><?php
                        echo HTML::anchor('admin/ajax/viewuser/'.$user->id, __('View'), array('class' => 'view'));
                        echo HTML::anchor('admin/users/edit/'.$user->id, __('Edit'));
                        echo HTML::anchor('admin/users/roles/'.$user->id, __('Roles'));
                        if ($thisuser->id != $user->id) {
                            echo HTML::anchor('admin/users/delete/'.$user->id, __('Delete'));
                        }
                    ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php echo $page_links; ?>
            <?php
            } else {
                echo HTML::flash_message(__('No users found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>