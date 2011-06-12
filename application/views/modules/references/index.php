<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {});
</script>

<div class="references">
    <?php foreach ($references AS $reference): ?>
        <h2><?php echo ($reference->company_name) ? $reference->company_name : $reference->name; ?></h2>
        <?php 
        if ($reference->file):
        echo HTML::image_thumb($reference->file, 150, 60, TRUE);
        endif;
        ?>
        <div><?php echo $reference->reference_text; ?></div>
    <?php endforeach; ?>
</div>