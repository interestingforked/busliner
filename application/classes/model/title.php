<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Title extends ORM {

    // Relationships
    protected $_belongs_to = array(
        'pages' => array('model' => 'page'),
        'languages' => array('model' => 'language'),
    );

    // Validation rules
    protected $_rules = array(
        'slug' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(255),
        ),
        'title' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(255),
        ),
    );

    protected $_callbacks = array(
        'slug' => array('slug_available'),
    );

    public function slug_available(Validate $array, $field) {
        $exist = (bool) DB::select(array('COUNT("*")', 'total_count'))
                ->from('titles')
                ->where('slug', '=', $array[$field])
                ->where($this->_primary_key, '!=', $this->pk())
                ->execute()
                ->get('total_count');
        if ($exist) {
            $array->error($field, 'slug_available', array($array[$field]));
        }
    }

    public function get_page_title($page, $language) {
        $content = $this
            ->where('page_id','=',$page->id)
            ->and_where('language_id','=',$language->id)
            ->find();
        return $content->title;
    }


}
