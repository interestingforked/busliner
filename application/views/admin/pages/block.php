<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("a.ajaxview").fancybox({'titleShow':false,'transitionIn':'none','transitionOut':'none'});
});
<?php if (isset($open)) { ?>
$(document).ready(function() {
    var id = <?php echo $open['page'] ?>;
    var language = <?php echo $open['language'] ?>;
    if (($('li#page' + id + ' ul').length > 0) == false) {
        pages(id,language,'show');
    }
});
<?php } ?>
</script>
<?php I18n::lang(Session::instance()->get('admin_language')); ?>

<ul class="pages">
<?php 
foreach ($pages AS $page) {
    $titles = $page->titles->find_all();
    ?>
    <li id="page<?php echo $page->id; ?>">
        <div class="page">
        <span class="border">
            <a href="javascript:pages(<?php echo $page->id; ?>,<?php echo $language ?>,'show');" class="page_action">
                <img src="/media/img/admin/arrow_<?php echo (($page->childs) ? 'closed' : 'opened'); ?>.gif" alt="Open" />
            </a>
        </span>
        <?php if ($page->childs) { ?>
        <a href="javascript:pages(<?php echo $page->id; ?>,<?php echo $language ?>,'show');" class="page_action">
            <?php echo $page->title; ?>
        </a>
        <?php
        } else {
            echo $page->title;
        }
        ?>
        <div class="actions">
            <?php
            echo HTML::anchor('admin/pages/status/'.$page->id,
                    HTML::image(($page->status == 'published') ? 'media/img/admin/tick.png' : 'media/img/admin/cross.png' ),
			array('title' => __('Change status')));
            echo HTML::anchor('admin/pages/moveup/'.$page->id, HTML::image('media/img/admin/arrow_up.png'), array('title' => __('Move up')));
            echo HTML::anchor('admin/pages/movedown/'.$page->id, HTML::image('media/img/admin/arrow_down.png'), array('title' => __('Move down')));
            echo HTML::anchor('admin/pages/delete/'.$page->id, HTML::image('media/img/admin/page_delete.png'),
                    array('onclick' => 'return confirm("'.__('Are you sure you want to delete this page?').'")', 'title' => __('Move it to deleted')));
            ?>
        </div>
        <div class="actions">
            <?php
            echo HTML::anchor('admin/articles/index/'.$page->id, HTML::image('media/img/admin/comments.png'), array('title' => __('Page articles')));
            ?>
        </div>
        <div class="actions">
            <?php
            echo HTML::anchor('admin/pages/new/'.$page->id, HTML::image('media/img/admin/page_add.png'), array('title' => __('Add new translation to this page')));
            ?>
        </div>
            <div class="actions">
            <?php
            echo HTML::image('media/img/admin/page_white_delete.png').' : ';
            foreach ($titles AS $title) {
                $lang = ORM::factory('Language')->find($title->language_id);
                echo HTML::anchor('admin/pages/delete_language/'.$page->id.'/'.$lang->id, strtoupper($lang->locale), array('title' => __('Delete'), 'onclick' => 'return confirm("'.__('Are you sure you want to delete this page?').'")'));
            }
            ?>
        </div>
        <div class="actions">
            <?php
            echo HTML::image('media/img/admin/page_white_edit.png').' : ';
            foreach ($titles AS $title) {
                $lang = ORM::factory('Language')->find($title->language_id);
                echo HTML::anchor('admin/pages/edit/'.$page->id.'/'.$lang->id, strtoupper($lang->locale), array('title' => __('Edit page in').' '.$lang->title));
            }
            ?>
        </div>
        <div class="actions">
            <?php
            echo HTML::image('media/img/admin/page_white_text.png').' : ';
            foreach ($titles AS $title) {
                $lang = ORM::factory('Language')->find($title->language_id);
                echo HTML::anchor('admin/ajax/viewpage/'.$page->id.'/'.$lang->locale, strtoupper($lang->locale), array('class' => 'ajaxview', 'title' => __('View content')));
            }
            ?>
        </div>
        <?php if ( ! empty($page->url)) { ?>
            <div class="actions">URL</div>
        <?php } ?>
        <?php if ( ! empty($page->module)) { ?>
            <div class="actions"><?php echo __('Module'); ?></div>
        <?php } ?>
        </div>
    </li>
<?php } ?>
</ul>