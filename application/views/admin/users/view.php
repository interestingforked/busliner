<?php defined('SYSPATH') or die('No direct script access.'); ?>

<?php I18n::lang(Session::instance()->get('admin_language')); ?>

<div class="block500">
    <div id="content">
        <div class="block">
            <h4><?php echo $profile->display_name; ?></h4>
            <div class="content">
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Username'); ?></span>
                    <?php echo $user->username; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('E-mail'); ?></span>
                    <a href="mailto: <?php echo $user->email; ?>"><?php echo $user->email; ?></a>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Active'); ?></span>
                    <?php echo ($user->active==1) ? __('Yes') : __('No'); ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Last login'); ?></span>
                    <?php echo date("Y-m-d G:i:s", $user->last_login); ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Firstname, lastname'); ?></span>
                    <?php echo $profile->first_name.' '.$profile->last_name; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Company'); ?></span>
                    <?php echo $profile->company; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Gender'); ?></span>
                    <?php echo $profile->get_gender($profile->gender); ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Language'); ?></span>
                    <?php echo $profile->language; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Phone'); ?></span>
                    <?php echo $profile->phone; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Mobile phone'); ?></span>
                    <?php echo $profile->mobile; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Address'); ?></span>
                    <?php echo $profile->address; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Skype'); ?></span>
                    <?php echo $profile->skype_handle; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('MSN'); ?></span>
                    <?php echo $profile->msn_handle; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Twitter'); ?></span>
                    <?php echo $profile->twitter_handle; ?>&nbsp;
                </div>
                <div class="form-row-long">
                    <span class="tag"><?php echo __('Website'); ?></span>
                    <a href="<?php echo $profile->website; ?>"><?php echo $profile->website; ?></a>&nbsp;
                </div>
            </div>
        </div>
    </div>
</div>