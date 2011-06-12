<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Reference extends ORM {

    // Relationships

    // Validation rules
    protected $_rules = array(
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(4),
            'max_length' => array(150),
        ),
        'postcode' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(10),
        ),
        'city' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(100),
        ),
        'country' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(100),
        ),
        'e_mail' => array(
            'not_empty' => NULL,
            'email' => NULL,
        ),
        'phone' => array(
            'not_empty' => NULL,
            'min_length' => array(5),
            'max_length' => array(20),
        ),
        'reference_text' => array(
            'not_empty' => NULL,
        ),
    );

    public function get_references($id = NULL) {
        $sql = "SELECT * FROM `references` WHERE active = 1 ORDER BY `created` DESC";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute();
        return ($id) ? $result->current() : $result->as_array();
    }

}
