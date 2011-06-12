<?php defined('SYSPATH') or die('No direct script access.'); ?>

<?php
$news = ORM::factory('News')->get_last_news();
if ($news->count()) {
?>
<div class="block">
    <div class="news">
		<?php if (isset($title)) { ?>
		<h3 class="c<?php echo Session::instance()->get('h3class'); ?>"><a href="/news"><?php echo $title; ?></a></h3>
		<?php } ?>
        <ul>
        <?php
        foreach ($news AS $article) {
        ?>
            <li>
                <span><?php echo Date::human_date($article->created); ?></span>
                <a href="/news/<?php echo $article->slug; ?>"><?php echo $article->title; ?></a>
            </li>
        <?php } ?>
        </ul>
    </div>
</div>
<div class="clear"></div>
<?php } ?>