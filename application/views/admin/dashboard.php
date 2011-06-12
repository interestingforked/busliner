<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("a.view").fancybox({'scrolling':'no','transitionIn':'none','transitionOut':'none'});
});
</script>

<div id="content">
    <div class="grid_8">
        <div class="block">
            <h4 onclick="tb(1)"><?php echo __('Latest pages'); ?><span></span></h4>
            <div class="content" id="block1">
            <?php if ($pages->count()) { ?>
                <ul class="dashboard">
                <?php foreach ($pages AS $page) {
                    $data = $page->get_page_data($page->id);
                ?>
                    <li>
                        <span class="date"><?php echo $page->created; ?></span>
                        <?php echo HTML::anchor('admin/ajax/viewpage/'.$page->id.'/'.$data['language']->locale, $data['title']->title, array('class' => 'view')); ?>
                        <span class="language">(<?php echo $data['language']->title; ?>)</span>
                    </li>
                <?php } ?>
                </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No articles found!'), HTML::WARNING);
            }
            ?>
            </div>
        </div>
        <div class="block">
            <h4 onclick="tb(3)"><?php echo __('Latest news'); ?><span></span></h4>
            <div class="content" id="block3">
            <?php if ($news->count()) { ?>
                <ul class="dashboard">
                <?php foreach ($news AS $article) { ?>
                    <li>
                        <span class="date"><?php echo $article->created; ?></span>
                        <?php echo HTML::anchor('news/'.$article->slug, $article->title); ?>
                    </li>
                <?php } ?>
                </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No articles found!'), HTML::WARNING);
            }
            ?>
            </div>
        </div>
        <div class="block">
            <h4 onclick="tb(2)"><?php echo __('Latest comments'); ?><span></span></h4>
            <div class="content" id="block2">
                <h5><?php echo __('Waiting for approvement'); ?></h5>
            <?php if ($disabled_comments->count()) { ?>
                <ul class="dashboard">
                <?php foreach ($disabled_comments AS $comment) {
                    $title = $comment->get_title($comment->id);
                ?>
                    <li>
                        <span class="date"><?php echo $comment->created; ?></span>
                        <?php echo HTML::anchor('admin/ajax/viewcomment/'.$comment->id, $comment->name.' ('.$comment->email.')', array('class' => 'view')); ?><br/>
                        <span class="comment-data"><b><?php echo __(ucfirst($comment->module)); ?></b> : <?php echo HTML::anchor((($comment->module!='pages')?$comment->module.'/':'').$title->slug, $title->title); ?></span>
                    </li>
                <?php } ?>
                </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No unapproved comments found!'), HTML::WARNING);
            }
            ?>
                <h5><?php echo __('Approved comments'); ?></h5>
            <?php if ($active_comments->count()) { ?>
                <ul class="dashboard">
                <?php foreach ($active_comments AS $comment) {
                    $title = $comment->get_title($comment->id);
                ?>
                    <li>
                        <span class="date"><?php echo $comment->created; ?></span>
                        <?php echo HTML::anchor('admin/ajax/viewcomment/'.$comment->id, $comment->name.' ('.$comment->email.')', array('class' => 'view')); ?><br/>
                        <span class="comment-data"><b><?php echo __(ucfirst($comment->module)); ?></b> : <?php echo HTML::anchor((($comment->module!='pages')?$comment->module.'/':'').'/'.$title->slug, $title->title); ?></span>
                    </li>
                <?php } ?>
                </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No approved comments found!'), HTML::WARNING);
            }
            ?>
            </div>
        </div>
    </div>
    <div class="grid_8">
        <div class="block">
            <h4 onclick="tb(5)"><?php echo __('Last logged users'); ?><span></span></h4>
            <div class="content" id="block5">
            <?php if ($users->count()) { ?>
                <ul class="dashboard">
                <?php foreach ($users AS $user) { ?>
                    <li>
                        <span class="date"><?php echo $user->last_login_date; ?></span>
                        <?php echo HTML::anchor('admin/ajax/viewuser/'.$user->id, $user->get_fullname($user->id), array('class' => 'view')); ?>
                    </li>
                <?php } ?>
                </ul>
            <?php
            } else {
                echo HTML::flash_message(__('No users found!'), HTML::WARNING);
            }
            ?>
            </div>
        </div>
        <div class="block">
            <h4 onclick="tb(4)"><?php echo __('Last activity'); ?><span></span></h4>
            <div class="content" id="block4">
                <?php if ($protocol->count()) {?>
                <ul class="dashboard">
                <?php foreach ($protocol AS $action) { 
                    $user = ORM::factory('User')->get_fullname($action->user_id);
                ?>
                    <li>
                        <span class="date"><?php echo $action->created; ?></span>
                        <span class="user"><?php echo $user; ?></span>
                        <span class="action">was <?php echo $action->action.'ed the '.$action->module.' (ID: '.$action->module_id.')'; ?></span>
                        <span class="message"><?php echo $action->message; ?></span>
                    </li>
                <?php } ?>
                </ul>
                <?php
                } else {
                    echo HTML::flash_message(__('No actions found!'), HTML::WARNING);
                }
                ?>
            </div>
        </div>
    </div>
</div>