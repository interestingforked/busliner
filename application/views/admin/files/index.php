<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#elfinder').elfinder({
        url:'/vendor/connector.php',
        lang:'en',
        docked:true,
        height:450
    });
});
</script>

<div id="elfinder"></div>