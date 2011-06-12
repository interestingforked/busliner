<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("a.ajaxview").fancybox({'titlePosition':'inside','transitionIn':'none','transitionOut':'none'});
});
</script>

<div id="content">
    <div class="block">
        <h4><?php echo __('Deleted pages'); ?></h4>
        <div class="content">
            <?php if ($pages->count()) { ?>
            <ul class="list">
                <?php foreach ($pages AS $page) { ?>
                <li>
                    <span class="border"></span>
                    <?php echo ORM::factory('Title')->get_page_title($page, $language); ?>
                    <div class="actions">
                        <?php
                        echo HTML::anchor('admin/pages/restore/'.$page->id, HTML::image('media/img/admin/page_go.png'), array('title' => __('Restore')));
                        echo HTML::anchor('admin/pages/remove/'.$page->id, HTML::image('media/img/admin/page_delete.png'),
                                array('onclick' => 'return confirm("'.__('Are you sure you want to completely delete this page?').'")', 'title' => __('Delete page')));
                        ?>
                    </div>
                    <div class="actions">
            <?php
            echo __('View').': ';
            $contents = $page->contents->find_all();
            foreach ($contents AS $content) {
                $lang = ORM::factory('Language')->find($content->language_id);
                echo HTML::anchor('admin/ajax/viewpage/'.$page->id.'/'.$lang->locale, strtoupper($lang->locale), array('class' => 'ajaxview'));
            }
            ?>
        </div>
                </li>
                <?php } ?>
            </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No pages found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>
