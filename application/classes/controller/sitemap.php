<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sitemap extends Controller_Application {

    public function action_index($id = NULL) {
        $content = $this->template->content = View::factory('sitemap/index');
        $content->language = $this->language;
        $this->breadcrumbs['sitemap'] = __('Карта сайта');
        $this->template->title = __('Карта сайта');
    }

}