<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $("a[rel=gallery]").fancybox({'transitionIn':'none','transitionOut':'none','titlePosition':'over'})
    $("#send").click(function (e) {
		e.preventDefault();
        window.open($(this).attr('href'),"send_link","menubar=no,resizable=yes,width=500,height=410,scrollbars=no,dependent=yes,toolbar=no,status=no");
    });
});
</script>

<div class="content">
    <h1><?php echo $article->title; ?><span><?php echo Date::human_date($article->created); ?></span></h1>
    <?php if (!$print) { ?>
    <div class="tools">
        <?php echo HTML::anchor(Request::instance()->uri.'?print', __('Izdrukas versija'), array('target' => '_blank')); ?>
        <br/>
        <?php
        $data = array(
            'url' => Request::instance()->uri,
            'title' => $article->title,
        );
        Session::instance()->set('send', $data);
        echo HTML::anchor('send', __('Nosūtīt saiti'), array('id' => 'send')); ?>
    </div>
    <?php } ?>
    <div class="body">
        <p><?php
        $image = Text::get_image($article->body);
        if ($image) {
        ?>
        <img style="float:left;margin-right:10px;" src="/vendor/thumb.php?src=<?php echo Text::get_image($article->body); ?>&w=100&h=75&zc=1" alt="<?php echo $article->title; ?>" />
        <?php
        }
        echo $article->intro;
        ?></p>
        <?php 
		if ($image) {
			echo Text::strip_image($article->body, 135, 100); 
		} else {
			echo $article->body;
		}
		?>
    </div>
    <?php if ($photos->count() AND !$print) { ?>
    <div class="attaches">
        <h5><?php echo __('Pievienotie attēli'); ?></h5>
        <ul class="photos">
            <?php
            foreach ($photos AS $photo) {
                $filename = $photo->filename.'.'.$photo->extension;
                $file = DS.$photo->path.DS.$filename;
            ?>
            <li><a rel="gallery" href="<?php echo $file; ?>"><img src="/vendor/thumb.php?src=<?php echo $file; ?>&w=120&h=85&zc=1" alt="<?php echo $filename; ?>" /></a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>

    <?php if ($documents->count() AND !$print) { ?>
    <div class="attaches">
        <h5><?php echo __('Pievienotie dokumenti'); ?></h5>
        <ul>
            <?php
            foreach ($documents AS $document) {
                $filename = $document->filename.'.'.$document->extension;
            ?>
            <li><a href="<?php echo DS.$document->path.DS.$filename; ?>"><?php echo $filename; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
</div>
<?php if ($article->comments_enabled AND !$print) { ?>
<div class="comments">
    <h3><?php echo __('Komentāri'); ?></h3>
    <?php if ($comments->count()) { ?>
    <ul>
        <?php foreach ($comments AS $comment) { ?>
        <li id="comment-<?php echo $comment->id ?>">
            <div class="user"><?php echo $comment->name; ?><span><?php echo $comment->created; ?></span></div>
            <div class="text"><?php echo $comment->comment; ?></div>
        </li>
        <?php } ?>
    </ul>
    <?php } else { ?>
    <div class="warning"><?php echo __('Nav komentāru!'); ?></div>
    <?php } ?>
    <h3><?php echo __('Pievienot komentāru'); ?></h3>
    <?php if (isset($errors)) { echo HTML::flash_message($errors); } ?>
    <?php echo Form::open(); ?>
    <?php echo Form::hidden('module', 'news'); ?>
    <?php echo Form::hidden('module_id', $article->id); ?>
    <div class="form-row">
        <?php echo Form::label('name', __('Vārds'), NULL, TRUE); ?>
        <?php echo Form::input('name'); ?>
    </div>
    <div class="form-row">
        <?php echo Form::label('email',  __('E-mail'), NULL, TRUE); ?>
        <?php echo Form::input('email'); ?>
    </div>
    <div class="form-row">
        <?php echo Form::label('comment',  __('Komentārs'), NULL, TRUE); ?>
        <?php echo Form::textarea('comment', '', array('rows' => 4, 'cols' => 50)); ?>
    </div>
    <div class="form-row">
        <?php echo Form::submit('submit', __('Pievienot')); ?>
    </div>
    <?php echo Form::close(); ?>
</div>
<?php } ?>
