<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Roles extends Controller_Admin_Application {

    public $auth_required = array('admin');
 
    public function action_index() {
        $this->template->title = __('Roles');
        $content = $this->template->content = View::factory('admin/roles/index');
        $roles = ORM::factory('Role')->find_all();
        $content->roles = $roles;
    }

    public function action_new() {
        $this->template->title = __('Add role');
        $content = $this->template->content = View::factory('admin/roles/edit');
        $role = ORM::factory('Role');
        if ($_POST) {
            $role->values($_POST);
            if ($role->check()) {
                $role->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'roles',
                    'module_id' => $role->id,
                    'action' => 'new',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/roles');
            }
            else {
                $content->errors = $role->validate()->errors('validate');
            }
        }
        $content->role = $role;
    }

    public function action_edit($id) {
        $this->template->title = __('Edit role');
        $content = $this->template->content = View::factory('admin/roles/edit');
        $role = ORM::factory('Role')->find($id);
        if ($_POST) {
            $role->values($_POST);
            if ($role->check()) {
                $role->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'roles',
                    'module_id' => $role->id,
                    'action' => 'edit',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/roles');
            }
            else {
                $content->errors = $role->validate()->errors('validate');
            }
        }
        $content->role = $role;
    }

    public function action_delete($id) {
        ORM::factory('Role')->delete($id);

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'roles',
            'module_id' => $id,
            'action' => 'delete',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/roles');
    }

}

// End Application
