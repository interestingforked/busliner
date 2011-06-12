<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Category extends ORM {

    // Relationships
    protected $_has_many = array('news' => array('model' => 'news'));

    // Validation rules
    protected $_rules = array(
        'slug' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(50),
        ),
        'title' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(50),
        ),
    );

    public function get_categories() {
        return $this
            ->where('show','=','1')
            ->find_all();
    }
    
    // CACHABLE
    public function get_category_sql($slug = NULL) {
        $condition = ($slug) ? "AND slug = '{$slug}'" : "";
        $sql = "SELECT * "
            ."FROM categories "
            ."WHERE `show` = 1 {$condition}";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute();
        return ($slug) ? $result->current() : $result->as_array();
    }

}
