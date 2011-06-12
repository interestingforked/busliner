<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Profile extends ORM {

    // Relationships
    protected $_belongs_to = array('users' => array('model' => 'user'));

    // Validation rules
    protected $_rules = array(
        'display_name' => array(
            'not_empty' => NULL,
            'min_length' => array(4),
            'max_length' => array(50),
        ),
        'first_name' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(30),
        ),
        'last_name' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(30),
        ),
    );
    
    public function get_gender($gender) {
        switch($gender) {
            case 'm': $text = __('Male'); break;
            case 'f': $text = __('Female'); break;
            default: $text = __('Other'); break;
        }
        return $text;
    }

}
