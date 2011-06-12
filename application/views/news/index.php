<?php defined('SYSPATH') or die('No direct script access.'); ?>

<div class="content">
    <?php if (isset($page)) { ?>
        <h1><?php echo $page->title; ?></h1>
        <div class="body dotted-line"><?php echo $page->body; ?></div>
    <?php } else { ?>
        <h1><a href="/news"><?php echo __('Jaunākās ziņas!'); ?></a></h1>
    <?php } ?>
    <?php if ($news->count()) { ?>
    <ul class="news-full">
    <?php foreach ($news AS $article) { ?>
        <li>
            <?php
            $image = Text::get_image($article->body);
            if ($image) {
            ?>
            <img src="/vendor/thumb.php?src=<?php echo Text::get_image($article->body); ?>&w=100&h=75&zc=1" alt="<?php echo $article->title; ?>" />
            <?php } ?>
            <span><?php echo Date::human_date($article->created); ?></span>
            <h3><a href="/news/<?php echo $article->slug; ?>"><?php echo $article->title; ?></a></h3>
            <?php 
                if ( ! $article->intro) {
                    $intro = Text::get_intro($article->body);
                    if (strlen($intro) < 100) {
                        $intro = Text::limit_words($article->body, 50);
                    }
                } else {
                    $intro = $article->intro;
                }
		echo $intro;
	    ?>
            <div class="more"><a href="/news/<?php echo $article->slug; ?>"><?php echo __('Lasīt vairāk'); ?></a></div>
        </li>
    <?php } ?>
    </ul>
    <?php echo $page_links; ?>
    <?php } else { ?>
        <div class="warning"><?php echo __('Nav ziņu!'); ?></div>
    <?php } ?>
</div>
