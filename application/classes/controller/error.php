<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Application {

    public function action_404($id = FALSE) {
        $content = $this->template->content = View::factory('error/404');
        $content->language = $this->language->id;
        $content->uri = $id;

        $this->breadcrumbs['/'] = __('Page not found');
        $this->template->title = __('Page not found');
    }

    public function action_500($id = FALSE) {
        $content = $this->template->content = View::factory('error/500');
        $content->language = $this->language->id;
        $content->uri = $id;

        if (isset($this->request->exception)) {
            $content->exception = $this->request->exception;
        }

        $this->breadcrumbs['/'] = __('Error');
        $this->template->title = __('Error');
    }

}