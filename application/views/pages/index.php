<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#page-gallery a[rel="gallery"]').fancybox({'titleShow':false});
});
</script>

<h1><?php echo $title; ?></h1>
<?php echo $body; ?>

<?php
if (isset($module)) {
    echo $module;
}
?>

<?php if ($media): ?>
<div id="page-gallery">
    <?php
    foreach ($media AS $file):
        $photo = $file->path.'/'.$file->filename.'.'.$file->extension;
        echo HTML::anchor($photo, HTML::image_thumb($photo, $thumb_size['width'], $thumb_size['height']), array('rel' => 'gallery'));
    endforeach;
    ?>
</div>
<?php endif; ?>