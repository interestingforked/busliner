<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Application extends Controller_Template {

    public $index_page = FALSE;
    public $print = FALSE;
    public $template = 'main_layout';
    public $language;
    public $languages;
    public $config;
    public $referer;
    
    public $session;

    public $page = NULL;
    public $module = NULL;
    public $category = NULL;
    public $sidebar = NULL;
    public $breadcrumbs = array();

    public $cache;
    public $cacheinstance;

    public function before() {
        $this->index_page = (Request::instance()->controller == 'application');
        $this->print = (isset($_GET['print']));
        if ($this->index_page) {
            $this->template = 'index_layout';
        }
        if ($this->print) {
            $this->template = 'print_layout';
        }
        parent::before();

        $this->session = Session::instance();
        $this->config = Kohana::config('application');
        
        try {
            $settings = ORM::factory('Setting')->find_all();
            foreach ($settings AS $setting) {
                $key = $setting->key;
                if (isset($this->config->$key)) {
                    $this->config->$key = $setting->value;
                }
            }
        } catch (Exception $e) {
            Log::instance()->add(Log::WARNING, $e->getMessage());
        }

        $this->cache = $this->config->cache;
        if ($this->cache) {
            $this->cacheinstance = Cache::instance($this->config->cache_instance);
        }

        if ( ! $this->session->get('language')) {
            $this->language = ORM::factory('language')->get_language(0);
            $this->session->set('language', $this->language);
        } else {
            $this->language = $this->session->get('language');
        }

        $language = $this->request->param('language');
        if ($language AND $language != $this->language->locale) {
            $language = ORM::factory('language')->get_language(strtolower($language));
            if (isset($language->locale)) {
                $this->language = $language;
                $this->session->set('language', $this->language);
            }
        }
        I18n::lang($this->language->locale);

        if ($this->auto_render) {
            $this->template->title = '';
            $this->template->meta = array();
            $this->template->header = '';
            $this->template->navigation = '';
            $this->template->breadcrumbs = '';
            $this->template->sidebar = '';
            $this->template->page_sidebar = '';
            $this->template->content = '';
            $this->template->footer = '';
        }

        $this->referer = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL);
        $this->module = Request::instance()->controller;

        if ($this->cache AND $languages = $this->cacheinstance->get('languages')) {
            $this->languages = $languages;
        } else {
            $this->languages = ORM::factory('Language')->get_language(-1);
            if ($this->cache) {
                $this->cacheinstance->set('languages', $this->languages);
            }
        }

        $this->breadcrumbs['/'] = __('Home');
 
    }

    public function action_index() {
        $this->template->title = $this->config->meta_title;
        $this->template->content = View::factory('elements/index');
        $this->breadcrumbs = array();
    }

    public function after() {
        if ($this->auto_render) {
            $this->template->title = (($this->template->title)?$this->template->title.' / ':'').__('Orderman');
            $this->template->header = View::factory('elements/header');

            $this->template->navigation = View::factory('elements/navigation');
            $this->template->navigation->cache = $this->cache;
            $this->template->navigation->cacheinstance = $this->cacheinstance;
            $this->template->navigation->language = $this->language;
            $this->template->navigation->current = $this->page;

            $this->template->sidebar = View::factory('elements/sidebar');
            $this->template->sidebar->page = $this->page;

            $this->template->footer = View::factory('elements/footer');

            if (empty($this->template->meta)) {
                $this->template->meta = array(
                    'description' => $this->config->meta_description,
                    'keywords' => $this->config->meta_keywords,
                );
            }
            $this->template->breadcrumbs = View::factory('elements/breadcrumbs');
            $this->template->breadcrumbs->breadcrumbs = $this->breadcrumbs;
        }
        parent::after();
    }

}

// End Application
