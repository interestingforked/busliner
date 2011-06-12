<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Comment extends ORM {

    // Relationships

    // Validation rules
    protected $_rules = array(
        'module' => array(
            'not_empty' => NULL,
            'min_length' => array(4),
            'max_length' => array(30),
        ),
        'module_id' => array(
            'numeric' => NULL,
        ),
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(50),
        ),
        'email' => array(
            'not_empty' => NULL,
            'email' => NULL,
        ),
        'comment' => array(
            'not_empty' => NULL,
        ),
        'ip_address' => array(
            'ip' => NULL,
        ),
    );

    public function get_title($id) {
        $comment = $this->find($id);
        $language = ORM::factory('Language')->get_default();
        switch ($comment->module) {
            case 'pages':
                $page = ORM::factory('Page')->find($comment->module_id);
                $title = $page->titles->where('language_id','=',$language->id)->find();
                if ( ! $title->loaded()) {
                    $title = $page->titles->find();
                }
                return $title;
            break;
            case 'news':
                $article = ORM::factory('News')->find($comment->module_id);
                return $article;
            break;
        }
    }

}
