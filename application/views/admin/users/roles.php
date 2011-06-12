<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(function() {
    $('.select_buttons').click(function(){
        var arr = $(this).attr("name").split("2");
        var from = arr[0];
        var to = arr[1];
        $("#" + from + " option:selected").each(function(){
            $("#" + to).append($(this).clone());
            $(this).remove();
        });
    });
    $('#submit').click(function() {
        $('#user_roles option').each(function(index) {
            $(this).attr('selected',true);
        });
        return true;
    });
});
</script>

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
            <h4 onclick="tb(1)"><?php echo __('User roles'); ?><span></span></h4>
            <div class="content" id="block1">
                <div class="form-row-long">
                    <h5><?php echo $profile->first_name . ' ' . $profile->last_name; ?></h5>
                </div>
                <div class="form-row-long">
                <?php echo Form::label('user_roles', __('User roles')) ?>
                <?php echo Form::select('user_roles[]', $user_roles, NULL, $select_attr) ?>
                <input type="button" name="user_roles2roles" class="select_buttons" value="<?php echo __('Remove'); ?>"/>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('roles', __('Roles')) ?>
                <?php echo Form::select('roles[]', $roles, NULL, $select_attr) ?>
                <input type="button" name="roles2user_roles" class="select_buttons" value="<?php echo __('Add'); ?>"/>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>