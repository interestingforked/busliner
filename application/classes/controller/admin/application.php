<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Application extends Controller_Template {

    protected $auth;
    protected $user;
    
    public $template = 'admin_layout';
    public $auth_required = FALSE;
    public $secure_actions = FALSE;
    public $settings = array();
    public $breadcrumbs = array();
    public $referer;

    public $cache;
    public $cacheinstance;

    public function before() {
        if ($this->request->action == 'login') {
            $this->template = 'login_layout';
        }
        parent::before();

        $this->session = Session::instance();
        $this->auth = Auth::instance();
        $this->user = $this->auth->get_user();

        $action_name = $this->request->action;
        $controller_name = $this->request->controller;

        if (($this->auth_required !== FALSE && $this->auth->logged_in($this->auth_required) === FALSE)
                || (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) &&
                $this->auth->logged_in($this->secure_actions[$action_name]) === FALSE)) {
            if ($this->auth->logged_in()) {
                Request::instance()->redirect('admin/noaccess');
            } else {
                Request::instance()->redirect('admin/login');
            }
        }
        if ($this->user) {
            $roles_models = $this->user->roles->find_all();
            $roles = array();
            foreach ($roles_models AS $role) {
                $roles[] = $role->name;
            }
            $this->session->set('auth_user_roles', $roles);
        }

        $this->config = Kohana::config('application');

        $this->cache = $this->config->cache;
        if ($this->cache) {
            $this->cacheinstance = Cache::instance($this->config->cache_instance);
        }

        $this->referer = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL);

        if ($this->auto_render) {
            $this->template->title = '';
            $this->template->header = '';
            $this->template->navigation = '';
            $this->template->breadcrumbs = '';
            $this->template->content = '';
            $this->template->sidebar = '';
            $this->template->footer = '';
        }
        $wided = array('dashboard', 'files', 'noaccess');
        $this->template->wide = (in_array($controller_name, $wided) OR in_array($action_name, $wided));

        $language = ORM::factory('language')->get_default();
        $this->session->set('admin_language', $language->locale);
        I18n::lang($language->locale);
        if ($this->user) {
            $profile = $this->user->profiles->find();
            if ($profile) {
                if (isset($profile->language)) {
                    $this->session->set('admin_language', $profile->language);
                    I18n::lang($profile->language);
                }
            }
        }
    }

    public function action_login() {
        if ($this->auth->logged_in() != 0) {
            Request::instance()->redirect('admin/dashboard');
        }
        $this->template->title = __('Log in');
        $content = $this->template->content = View::factory('admin/login');
        if ($_POST) {
            $user = ORM::factory('user');
            $status = $user->login($_POST);
            if ($status) {
                Request::instance()->redirect('admin');
            } else {
                $content->errors = $_POST->errors('login');
            }
        }
    }

    public function action_force($user) {
        $this->auth->force_login($user);
        Request::instance()->redirect('admin');
    }

    public function action_logout() {
        $this->auth->logout();
        Request::instance()->redirect('admin');
    }

    public function action_noaccess() {
        $this->template->content = View::factory('admin/noaccess');
    }

    public function after() {
        if ($this->cache
                AND in_array($this->request->action, 
                    array('new', 'edit', 'delete', 'status', 'moveup', 'movedown', 'remove', 'restore', 'approve', 'unapprove'))) {
            $this->cacheinstance->delete_all();
        }
        $request = array(
            'controller' => $this->request->controller,
            'action' => $this->request->action,
        );
        if ($this->auto_render) {
            $this->template->title .= ' / ' . __('Administration');
            $this->template->header = View::factory('admin/header', array('user' => $this->user));
            $this->template->navigation = View::factory('admin/navigation', $request);
            $this->template->sidebar = View::factory('admin/sidebar', $request);
            $this->template->breadcrumbs = HTML::anchor_array($this->breadcrumbs, '<span>&raquo;</span>');

            $this->template->content->thisuser = $this->user;
        }
        parent::after();
    }

}

// End Application
