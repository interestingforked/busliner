<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Languages extends Controller_Admin_Application {

    public $secure_actions = array(
        'index' => array('editor'),
        'new' => array('editor'),
        'edit' => array('editor'),
        'moveup' => array('editor'),
        'movedown' => array('editor'),
        'delete' => array('admin'),
    );

    public function action_index() {
        $this->template->title = __('Languages');
        $content = $this->template->content = View::factory('admin/languages/index');
        $languages = ORM::factory('Language')->order_by('position')->find_all();
        $content->languages = $languages;
    }

    public function action_new() {
        $this->template->title = __('Add language');
        $content = $this->template->content = View::factory('admin/languages/edit');
        $language = ORM::factory('Language');
        if ($_POST) {
            $_POST['created'] = DB::expr('NOW()');
            $_POST['created_by'] = $this->user->id;
            $language->values($_POST);
            if ($language->check()) {
                $language->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'languages',
                    'module_id' => $language->id,
                    'action' => 'create',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/languages');
            } else {
                $content->errors = $language->validate()->errors('validate');
            }
        }
        $content->language = $language;
    }

    public function action_edit($id) {
        $this->template->title = __('Edit language');
        $content = $this->template->content = View::factory('admin/languages/edit');
        $language = ORM::factory('Language')->find($id);
        if ($_POST) {
            $language->values($_POST);
            if ($language->check()) {
                $language->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'languages',
                    'module_id' => $language->id,
                    'action' => 'edit',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/languages');
            } else {
                $content->errors = $language->validate()->errors('validate');
            }
        }
        $content->language = $language;
    }

    public function action_delete($id) {
        ORM::factory('Language')->delete($id);
        
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'languages',
            'module_id' => $id,
            'action' => 'delete',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/languages');
    }
	
	public function action_show($id) {
        $language = ORM::factory('Language')->find($id);
        $language->show = ($language->show == 1) ? 0 : 1 ;
        $language->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'languages',
            'module_id' => $language->id,
            'action' => 'show',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/languages');
    }

    public function action_moveup($id) {
        $language = ORM::factory('Language')->find($id);
        $position = $language->position;
        if ($position > 1) {
            $upper = ORM::factory('Language')
                ->and_where('position', '=', ($language->position - 1))
                ->find();
            if (count($upper) > 0) {
                $language->position = $upper->position;
                $language->save();
                $upper->position = $position;
                $upper->save();
            }
        }
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'languages',
            'module_id' => $language->id,
            'action' => 'moved up',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/languages');
    }

    public function action_movedown($id) {
        $language = ORM::factory('Language')->find($id);
        $position = $language->position;
        $max = ORM::factory('Language')
            ->select(array(DB::expr('MAX(`position`)'), 'max_position'), 'id')
            ->group_by('id')
            ->order_by('max_position', 'DESC')
            ->find()
            ->max_position;
        if ($position < $max) {
            $upper = ORM::factory('Language')
                ->and_where('position', '=', ($language->position + 1))
                ->find();
            if (count($upper) > 0) {
                $language->position = $upper->position;
                $language->save();
                $upper->position = $position;
                $upper->save();
            }
        }
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'languages',
            'module_id' => $language->id,
            'action' => 'moved down',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/languages');
    }

}

// End Application
