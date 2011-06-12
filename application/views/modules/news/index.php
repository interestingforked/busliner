<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {});
</script>

<div class="news">
    <?php if (count($news) == 0): ?>
    <p>Новостей не найдено</p>
    <?php endif; ?>
    
    <?php foreach ($news AS $item): ?>
    <div class="item">
    <div class="date"><?php echo date('d/m/Y', strtotime($item->created)); ?></div>
    <h2><?php 
    if (strlen($item->body) > 10) {
        echo HTML::anchor($uri.'/?'.$item->slug, $item->title); 
    } else {
        echo $item->title;
    }
    ?></h2>
    <div class="intro"><?php echo $item->intro; ?></div>
    <?php 
    $documents = ORM::factory('Media')->get_media_sql('news', $item->id, 'document');
    if ($documents): 
    ?>
    <ul id="documents">
        <?php
        foreach ($documents AS $file):
            echo '<li>'.HTML::anchor($file->path.'/'.$file->filename.'.'.$file->extension, $file->filename).'</li>';
        endforeach;
        ?>
    </ul>
    <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>