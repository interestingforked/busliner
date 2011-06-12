<?php defined('SYSPATH') or die('No direct script access.'); ?>

<ul class="navigation">
    <?php
    $main = isset($current['main']->page_id) ? $current['main']->page_id : 0;
    if ($cache AND $menu = $cacheinstance->get('menu0')):
    else:
        $menu = ORM::factory('Page')->get_navigation($language->id, 0);
        if ($cache):
            $cacheinstance->set('menu0', $menu);
        endif;
    endif;
    $i = 0;
    foreach ($menu AS $page):
        $class = array();
        if ($main == $page->page_id):
            $class[] = 'selected rc5';
        endif;
        echo '<li><ins class="'.implode(' ', $class).'">';
        $link = $language->locale.'/'.$page->slug;
        $attributes = array();
        if ($page->url) {
            $link = $page->url;
            $attributes['target'] = $page->url_target;
        }
        if ($main == $page->page_id):
            echo '<b class="selected">'.$page->title.'</b>';
        else:
            echo HTML::anchor($link, $page->title, $attributes);
        endif;
        if ($page->childs):
            echo '<ul class="sub_menu">';
            if ($cache AND $submenu = $cacheinstance->get('menu'.$page->page_id)):
            else:
                $submenu = ORM::factory('Page')->get_navigation($language->id, $page->page_id);
                if ($cache):
                    $cacheinstance->set('menu'.$page->page_id, $submenu);
                endif;
            endif;
            foreach ($submenu AS $subpage):
                echo '<li><ins>';
                $link = $language->locale.'/'.$page->slug.'/'.$subpage->slug;
                $attributes = array();
                if ($subpage->url) {
                    $link = $subpage->url;
                    $attributes['target'] = $subpage->url_target;
                }
                echo HTML::anchor($link, $subpage->title, $attributes);
                echo '</ins></li>';
            endforeach;
            echo '</ul>';
        endif;
        echo '</ins></li>';
        $i++;
    endforeach;
    ?>
</ul>