<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Block extends ORM {

    // Relationships
    protected $_belongs_to = array('languages' => array('model' => 'language'));

    // Validation rules
    protected $_rules = array(
        'type' => array(
            'not_empty' => NULL,
        ),
    );

    public function get_blocks($type, $plugin = NULL) {
        $condition = '';
        if ($plugin) {
            $condition = "AND plugin = '{$plugin}'";
        }
        $sql = "SELECT * FROM `blocks` WHERE type = '{$type}' {$condition} AND active = 1 ORDER BY `position` ASC";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute();
        return ($plugin) ? $result->current() : $result->as_array();
    }

    public function blocks($type, $plugin = NULL) {
        if ($plugin) {
            $block = $this->get_blocks($type, $plugin);
            if ($block->loaded()) {
                $view = View::factory('blocks/'.$block->plugin);
                if ($block->show_title) {
                    $view->title = $block->title;
                }
                $view->content = $block->content;
                return $view->render();
            }
        }
        $blocks = $this->get_blocks($type);
        if (count($blocks) > 0) {
            $content = '';
            foreach ($blocks AS $block) {
                if ($block->language_id > 0 AND $block->language_id != Session::instance()->get('language')->id) {
                    continue;
                }
                $view = View::factory('blocks/'.(($block->plugin) ? $block->plugin : 'block'));
                if ($block->show_title) {
                    $view->title = $block->title;
                }
                $view->content = $block->content;
                $content .= $view->render();
            }
            return $content;
        }
        return NULL;
    }

}
