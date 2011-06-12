<?php defined('SYSPATH') or die('No direct script access.'); ?>

<?php
$language = Session::instance()->get('language');
$count = ORM::factory('News')
    ->where('actual','!=',1)
    ->and_where('competition','!=',1)
    ->and_where('status','=','published')
    ->and_where('dontshow','=',0)
	->and_where('language_id','=',$language->id)
    ->count_all();
		
$pagination = Pagination::factory(array(
    'total_items' => $count,
    'items_per_page' => Kohana::config('application')->news_count_index,
));
$news = ORM::factory('News')
    ->where('actual','!=',1)
    ->and_where('competition','!=',1)
    ->and_where('status','=','published')
    ->and_where('dontshow','=',0)
	->and_where('language_id','=',$language->id)
    ->order_by('new','DESC')
    ->order_by('created','DESC')
    ->limit($pagination->items_per_page)
    ->offset($pagination->offset)
    ->find_all();

$page_links = $pagination->render();
?>

<div class="block">
	<?php if (isset($title)) { ?>
	<h3 class="c<?php echo Session::instance()->get('h3class'); ?>"><a href="/news"><?php echo $title; ?></a></h3>
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
            <h4><a href="/news/<?php echo $article->slug; ?>"><?php echo $article->title; ?></a></h4>
            <?php
                if ( ! $article->intro) {
                    $intro = Text::get_intro($article->body);
                    if (strlen($intro) < 100) {
                        $intro = Text::limit_words(strip_tags($article->body), 50);
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
        <div class="warning"><?php echo __('Nav zinas!'); ?></div>
    <?php } ?>
</div>
<div class="clear"></div>