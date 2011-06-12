<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Content extends ORM {

    // Relationships
    protected $_belongs_to = array(
        'pages' => array('model' => 'page'),
        'languages' => array('model' => 'language'),
    );

    // Validation rules
    protected $_rules = array(
        'content_title' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(255),
        ),
        'body' => array(
            'not_empty' => NULL,
        ),
    );

    public function get_page_title($page, $language) {
        $content = $this
            ->where('page_id','=',$page->id)
            ->and_where('language_id','=',$language->id)
            ->find();
        return $content->content_title;
    }

}
