<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div id="content">
    <div class="block">
        <h4><?php echo __('News'); ?></h4>
        <div class="content">
            <?php if ($news->count()) { ?>
            <ul class="list">
                <?php foreach ($news AS $article) { ?>
                <li>
                    <span class="border"></span>
                    <?php echo Text::limit_words($article->title,10); ?>
                    <div class="actions">
                        <?php
                        echo HTML::anchor('admin/news/status/'.$article->id,
                            HTML::image(($article->status == 'published') ? 'media/img/admin/tick.png' : 'media/img/admin/cross.png' ), array('title' => __('Change status')));
                        echo HTML::anchor('admin/news/edit/'.$article->id, HTML::image('media/img/admin/page_edit.png'), array('title' => __('Edit')));
                        echo HTML::anchor('admin/news/delete/'.$article->id, HTML::image('media/img/admin/page_delete.png'),
                                array('onclick' => 'return confirm("'.__('Are you sure you want to delete this article?').'")', 'title' => __('Delete')));
                        ?>
                    </div>
                    <div class="actions">
                        <?php echo $article->locale; ?>
                    </div>
                    <?php if ($article->actual == 1) { ?>
                    <div class="actions">
                        <?php echo __('Actual'); ?>
                    </div>
                    <?php } ?>
                    <?php if ($article->new == 1) { ?>
                    <div class="actions">
                        <?php echo __('New'); ?>
                    </div>
                    <?php } ?>
                    <?php if ($article->competition == 1) { ?>
                    <div class="actions">
                        <?php echo __('Konkurss'); ?>
                    </div>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
            <?php echo $page_links; ?>
            <?php
            } else {
                echo HTML::flash_message(__('No news found!'), HTML::WARNING);
            }
            ?>
        </div>
    </div>
</div>
