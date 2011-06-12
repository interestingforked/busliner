<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {});
</script>

<div class="news">
    <div class="body">
        <?php 
        echo $article->intro; 
        echo $article->body; 
        ?>
    </div>
    <?php if ($documents): ?>
    <p>Документы:</p>
    <ul id="documents">
        <?php
        foreach ($documents AS $file):
            echo '<li>'.HTML::anchor($file->path.'/'.$file->filename.'.'.$file->extension, $file->filename).'</li>';
        endforeach;
        ?>
    </ul>
    <?php endif; ?>
</div>