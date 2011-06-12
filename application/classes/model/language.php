<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Language extends ORM {

    // Relationships
    protected $_has_many = array(
        'contents' => array('model' => 'content'),
        'titles' => array('model' => 'title')
    );

    // Validation rules
    protected $_rules = array(
        'locale' => array(
            'not_empty' => NULL,
            'exact_length' => array(2),
        ),
        'title' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(30),
        ),
    );

    protected $_callbacks = array(
        'locale' => array('locale_available'),
    );

    public function locale_available(Validate $array, $field) {
        $exist = (bool) DB::select(array('COUNT("*")', 'total_count'))
            ->from('languages')
            ->where('locale', '=', $array[$field])
            ->where($this->_primary_key, '!=', $this->pk())
            ->execute()
            ->get('total_count');
        if ($exist) {
            $array->error($field, 'slug_available', array($array[$field]));
        }
    }

    public function get_default() {
        return $this->where('default','=','1')->find();
    }

    public function get_id_by_locale($locale) {
        return $this->where('locale','=',$locale)->find();
    }

    public function get_locale_by_id($id) {
        $language = $this->find($id);
        return $language->locale;
    }

    // CACHABLE
    public function get_language($id = NULL) {
        if ( ! isset($condition) AND $id == -1) {
            $condition = "`show` = 1";
        }
        if ( ! isset($condition) AND $id == 0) {
            $condition = "`default` = 1";
        }
        if ( ! isset($condition) AND is_integer($id)) {
            $condition = "`id` = {$id}";
        }
        if ( ! isset($condition) AND is_string($id)) {
            $condition = "`locale` = '{$id}'";
        }
        $sql = "SELECT * FROM `languages` WHERE {$condition} ORDER BY `position` ASC";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute();

        return ($id != -1) ? $result->current() : $result->as_array();
    }

}