<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Files extends Controller_Admin_Application {

    public $auth_required = array('editor');

    public function action_index() {
        $this->template->title = __('Files');
        $this->template->content = View::factory('admin/files/index');
    }

}

// End Application
