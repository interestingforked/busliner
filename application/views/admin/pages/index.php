<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <div class="block">
        <h4><?php echo __('Pages'); ?></h4>
        <div class="content">
		<!--
            <div class="languages">
            <?php
            foreach ($languages AS $lang) {
                echo HTML::anchor('admin/pages/index/'.$lang->locale, $lang->title);
                echo '&nbsp;';
            }
            ?>
            </div>
		-->
            <?php
            if ($results > 0) {
                echo $pages;
            } else {
                echo HTML::flash_message(__('No pages found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>
