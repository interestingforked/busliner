<?php
defined('SYSPATH') or die('No direct script access.');
$roles = Session::instance()->get('auth_user_roles');
?>

<ul>
    <li><?php echo HTML::nav('admin/dashboard', __('Dashboard'), in_array($controller, array('dashboard'))); ?></li>
    <li><?php echo HTML::nav('admin/pages', __('Pages'), in_array($controller, array('pages', 'languages'))) ?></li>
    <li><?php echo HTML::nav('admin/news', __('News'), in_array($controller, array('news', 'categories'))) ?></li>
    <li><?php echo HTML::nav('admin/references', __('References'), in_array($controller, array('references'))) ?></li>
    <li><?php echo HTML::nav('admin/blocks', __('Elements'), in_array($controller, array('blocks'))) ?></li>
    <li><?php echo HTML::nav('admin/files', __('Files'), in_array($controller, array('files'))) ?></li>
    <?php if (in_array('admin', $roles)) {?>
        <li><?php echo HTML::nav('admin/users', __('Users'), in_array($controller, array('users', 'roles'))) ?></li>
        <li><?php echo HTML::nav('admin/settings', __('Settings'), in_array($controller, array('settings'))) ?></li>
    <?php } ?>
</ul>
