<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Categories extends Controller_Admin_Application {

    public $secure_actions = array(
        'index' => array('editor'),
        'new' => array('editor'),
        'edit' => array('editor'),
        'show' => array('editor'),
        'delete' => array('admin'),
    );

    public function action_index() {
        $this->template->title = __('Categories');
        $content = $this->template->content = View::factory('admin/categories/index');
        $categories = ORM::factory('Category')->find_all();
        $content->categories = $categories;
    }

    public function action_new() {
        $this->template->title = __('Add category');
        $content = $this->template->content = View::factory('admin/categories/edit');
        $category = ORM::factory('Category');
        if ($_POST) {
            if ( ! $_POST['slug']) {
                $_POST['slug'] = Text::slugify($_POST['title']);
            }
            $_POST['created'] = DB::expr('NOW()');
            $_POST['created_by'] = $this->user->id;
            $category->values($_POST);
            if ($category->check()) {
                $category->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'categories',
                    'module_id' => $category->id,
                    'action' => 'create',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/categories');
            }
            else {
                $content->errors = $category->validate()->errors('validate');
            }
        }
        $content->category = $category;
    }

    public function action_edit($id) {
        $this->template->title = __('Edit category');
        $content = $this->template->content = View::factory('admin/categories/edit');
        $category = ORM::factory('Category')->find($id);
        if ($_POST) {
            if ( ! $_POST['slug']) {
                $_POST['slug'] = Text::slugify($_POST['title']);
            }
            $_POST['show'] = Arr::get($_POST, 'show', 0);
            $category->values($_POST);
            if ($category->check()) {
                $category->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'categories',
                    'module_id' => $category->id,
                    'action' => 'edit',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/categories');
            }
            else {
                $content->errors = $category->validate()->errors('validate');
            }
        }
        $content->category = $category;
    }

    public function action_delete($id) {
        ORM::factory('Category')->delete($id);
        
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'categories',
            'module_id' => $id,
            'action' => 'delete',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/categories');
    }

    public function action_show($id) {
        $category = ORM::factory('Category')->find($id);
        $category->show = ($category->show == 1) ? 0 : 1 ;
        $category->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'categories',
            'module_id' => $category->id,
            'action' => 'show',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/categories');
    }

}

// End Application
