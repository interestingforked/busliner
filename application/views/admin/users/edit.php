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
        <h4 onclick="tb(1)"><?php echo __('User info'); ?><span></span></h4>
        <div class="content" id="block1">
            <div class="form-row-long">
                <?php echo Form::label('username', __('Username'), NULL, TRUE) ?>
                <?php echo Form::input('username', $user->username) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('email', __('E-mail'), NULL, TRUE) ?>
                <?php echo Form::input('email', $user->email) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('password', __('Password')) ?>
                <?php echo Form::input('password') ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('password_confirm', __('Password confirm')) ?>
                <?php echo Form::input('password_confirm') ?>
            </div>
        </div>
    </div>
    <div class="block">
        <h4 onclick="tb(2)"><?php echo __('User profile'); ?><span></span></h4>
        <div class="content" id="block2">
            <div class="form-row-long">
                <?php echo Form::label('display_name', __('Display name'), NULL, TRUE) ?>
                <?php echo Form::input('display_name', $profile->display_name) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('first_name', __('First name'), NULL, TRUE) ?>
                <?php echo Form::input('first_name', $profile->first_name, array('size' => 30)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('last_name', __('Last name'), NULL, TRUE) ?>
                <?php echo Form::input('last_name', $profile->last_name, array('size' => 30)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('company', __('Company')) ?>
                <?php echo Form::input('company', $profile->company, array('size' => 35)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('language', __('Language')) ?>
                <?php echo Form::select('language', $languages, $profile->language) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('gender', __('Gender')) ?>
                <?php echo Form::select('gender', $genders, $profile->gender) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('phone', __('Phone')) ?>
                <?php echo Form::input('phone', $profile->phone) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('mobile', __('Mobile phone')) ?>
                <?php echo Form::input('mobile', $profile->mobile) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('address', __('Address')) ?>
                <?php echo Form::input('address', $profile->address, array('size' => 40)) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('skype_handle', __('Skype')) ?>
                <?php echo Form::input('skype_handle', $profile->skype_handle) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('msn_handle', __('MSN')) ?>
                <?php echo Form::input('msn_handle', $profile->msn_handle) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('twitter_handle', __('Twitter')) ?>
                <?php echo Form::input('twitter_handle', $profile->twitter_handle) ?>
            </div>
            <div class="form-row-long">
                <?php echo Form::label('website', __('Website')) ?>
                <?php echo Form::input('website', $profile->website, array('size' => 40)) ?>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>