<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pages extends Controller_Application {
    
    public function before() {
        parent::before();
        $this->session->delete('page_title');
    }

    public function action_index() {
        $content = $this->template->content = View::factory('pages/index');

        $pageslug = $this->request->param('page');
        if ($this->cache) {
            $page = $this->cacheinstance->get('longslug_'.$pageslug, NULL);
            if ( ! $page) {
                $page = ORM::factory('Page')->get_page($pageslug, TRUE);
                $this->cacheinstance->set('longslug_'.$pageslug, $page);
            }
        } else {
            $page = ORM::factory('Page')->get_page($pageslug);
        }
        if ( ! isset($page->slug)) {
            throw new Request_Exception($page);
        }

        $slugs = explode('/', $page->long_slug);
        $c = count($slugs);
        $i = 0;
        $exist = true;
        foreach ($slugs AS $slug) { $i++;
            if ($this->cache) {
                $page = $this->cacheinstance->get('slug_'.$slug, NULL);
                if ( ! $page) {
                    $page = ORM::factory('Page')->get_page($slug);
                    $this->cacheinstance->set('slug_'.$slug, $page);
                }
            } else {
                $page = ORM::factory('Page')->get_page($slug);
            }
            if ( ! isset($this->page['main'])) {
                $this->page['main'] = $page;
            }
            if ($i == $c) {
                $this->page['current'] = $page;
            }
            $this->page['breadcrumbs'][$page->slug] = $page->title;
        }

        $current_page = $this->page['current'];

        $modules = $this->config->simple_modules;
        if (in_array($current_page->module, $modules)) {
            $request = Request::factory('modules/'.$current_page->module);
            $request->uri = $this->language->locale.'/'.$pageslug;
            if ($_POST) {
                $request->post = $_POST;
            }
            if ($_FILES) {
                $request->files = $_FILES;
            }
            $module = $request->execute();
            $content->module = $module;
        }

        $content->page = $current_page;
        
        $content->title = $current_page->content_title;
        if ($page_title = $this->session->get('page_title')) {
            $content->title = $page_title;
        }
        $content->body = (trim($current_page->body) != '&nbsp;') ? $current_page->body : '';

        if ($this->cache) {
            $media = $this->cacheinstance->get('pagemedia_'.$current_page->page_id, NULL);
            if ( ! $media) {
                $media = ORM::factory('Media')->get_media_sql('pages', $current_page->page_id, 'photo');
                $this->cacheinstance->set('pagemedia_'.$current_page->page_id, $media);
            }
        } else {
            $media = ORM::factory('Media')->get_media_sql('pages', $current_page->page_id, 'photo');
        }
        $content->media = $media;
        $content->thumb_size = $this->config->thumb_size;

        $this->template->page_sidebar = $current_page->sidebar;
        
        $this->template->meta['description'] = $current_page->meta_description;
        $this->template->meta['keywords'] = $current_page->meta_keywords;
        $this->template->title = ( ! empty($current_page->meta_title))
                ? $current_page->meta_title : $current_page->title;

        $link = '';
        foreach ($this->page['breadcrumbs'] AS $k => $v) {
            $link .= ( ! empty($link)) ? '/'.$k : $k;
            $this->breadcrumbs[$link] = $v;
        }
    }

}