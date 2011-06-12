<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Dashboard extends Controller_Admin_Application {

    public $auth_required = array('login');

    public function action_index() {
        $this->template->title = __('Dashboard');
        $content = $this->template->content = View::factory('admin/dashboard');
        $content->protocol = ORM::factory('Protocol')
                ->order_by('created', 'DESC')
                ->limit(15)
                ->find_all();
        $content->pages = ORM::factory('Page')
                ->order_by('created', 'DESC')
                ->limit(5)
                ->find_all();
        $content->news = ORM::factory('News')
                ->order_by('created', 'DESC')
                ->limit(5)
                ->find_all();
        $content->active_comments = ORM::factory('Comment')
                ->where('active','=','1')
                ->order_by('created', 'DESC')
                ->limit(5)
                ->find_all();
        $content->disabled_comments = ORM::factory('Comment')
                ->where('active','=','0')
                ->order_by('created', 'DESC')
                ->limit(5)
                ->find_all();
        $content->users = ORM::factory('User')
                ->select(array(DB::expr('FROM_UNIXTIME(users.last_login)'), 'last_login_date'))
                ->order_by('last_login_date', 'DESC')
                ->limit(5)
                ->find_all();
    }

}

// End Application
