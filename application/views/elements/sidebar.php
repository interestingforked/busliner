<?php defined('SYSPATH') or die('No direct script access.'); ?>

<?php

$current = $page['current'];
if ($current->sidebar != ""):
    echo $current->sidebar;
else:
    echo ORM::factory('Block')->blocks('page_right');
endif;

?>