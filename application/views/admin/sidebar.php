<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div class="block">
    <h4><?php echo __('Menu'); ?></h4>
    <ul>
    <?php 
    switch($controller) {
        case 'blocks':
            echo HTML::sidebar_menu('admin/blocks', __('List blocks'));
            echo HTML::sidebar_menu('admin/blocks/new', __('New block'));
        break;
        case 'comments':
            echo HTML::sidebar_menu('admin/comments/', __('Waiting for approvement'));
            echo HTML::sidebar_menu('admin/comments/approved', __('Approved comments'));
        break;
        case 'references':
            echo HTML::sidebar_menu('admin/references/', __('Waiting for approvement'));
            echo HTML::sidebar_menu('admin/references/approved', __('Approved references'));
        break;
        case 'pages':
        case 'languages':
            echo HTML::sidebar_menu('admin/pages/', __('Page list'));
            echo HTML::sidebar_menu('admin/pages/new', __('New page'));
            echo HTML::sidebar_menu('admin/pages/deleted', __('Deleted pages'));
            echo HTML::sidebar_menu('admin/languages/', __('Language list'));
            echo HTML::sidebar_menu('admin/languages/new', __('New language'));
        break;
        case 'news':
        case 'categories':
            echo HTML::sidebar_menu('admin/news/', __('Article list'));
            echo HTML::sidebar_menu('admin/news/new', __('New article'));
            echo HTML::sidebar_menu('admin/categories/', __('Categories'));
            echo HTML::sidebar_menu('admin/categories/new', __('New category'));
        break;
        case 'users':
        case 'roles':
            echo HTML::sidebar_menu('admin/users/', __('List users'));
            echo HTML::sidebar_menu('admin/users/new', __('New user'));
            echo HTML::sidebar_menu('admin/roles', __('Roles'));
        break;
        case 'settings':
            echo HTML::sidebar_menu('admin/settings/', __('Settings'));
        break;
    }
    ?>
    </ul>
</div>
