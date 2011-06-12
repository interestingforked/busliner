<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Setting extends ORM {

    // Relationships

    // Validation rules
    protected $_rules = array(
        'key' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(100),
        ),
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(150),
        ),
        'value' => array(
            'min_length' => array(1),
            'max_length' => array(250),
        ),
    );

    public function get_value($key) {
        return $this->where('key', '=', $key)->find();
    }

    public function save_value($key, $value) {
        $setting = $this->get_value($key);
        if ($setting->loaded()) {
            $setting->value = $value;
            $setting->save();
            return $setting->saved();
        }
        return FALSE;
    }

}