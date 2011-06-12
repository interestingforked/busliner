<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Protocol extends ORM {

    // Relationships
    protected $_has_many = array('users' => array('model' => 'user'));

    // Validation rules
    protected $_rules = array(
        'action' => array(
            'not_empty' => NULL,
        ),
    );

    public function write(array $data) {
        $this->values($data);
        if ($this->check()) {
            $this->created = DB::expr('NOW()');
            $this->save();
            return TRUE;
        }
        return FALSE;
    }

}
