<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div class="content">
    <div class="block">
        <div class="news">
            <h3><a href="/news"><?php echo __('Jaunākās ziņas!'); ?></a></h3>
        </div>
    </div>
    <?php if (count($news) > 0) { ?>
    <ul class="news-full">
    <?php foreach ($news AS $article) { ?>
        <li>
            <span><?php echo Date::human_date($article['pubDate']); ?></span>
            <h3><a href="<?php echo $article['link']; ?>"><?php echo $article['title']; ?></a></h3>
            <?php echo $article['description']; ?>
            <div class="more"><a href="<?php echo $article['link']; ?>"><?php echo __('Read more'); ?></a></div>
        </li>
    <?php } ?>
    </ul>
    <?php } else { ?>
        <div class="warning"><?php echo __('Nav ziņu!'); ?></div>
    <?php } ?>
</div>