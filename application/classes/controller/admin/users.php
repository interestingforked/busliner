<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Admin_Application {

    public $auth_required = array('admin');

    public function action_index() {
        $this->template->title = __('Users');
        $content = $this->template->content = View::factory('admin/users/index');
        $count = ORM::factory('User')->where('active','=','0')->count_all();
        $pagination = Pagination::factory(array('total_items' => $count));
        $users = ORM::factory('User')
            ->order_by('username','ASC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();
        $content->users = $users;
        $content->page_links = $pagination->render();
    }

    public function action_new() {
        $this->template->title = __('Add user');
        $content = $this->template->content = View::factory('admin/users/edit');

        $user = ORM::factory('User');
        $profile =  ORM::factory('Profile');

        if ($_POST) {
            $user->values($_POST);
            if ($user->check()) {
                $user->save();
                if ($user->saved()) {

                    $login_role = new Model_Role(array('name' =>'login'));
                    $user->add('roles',$login_role);

                    $_POST['user_id'] = $user->id;

                    $profile->values($_POST);
                    if ($profile->check()) {
                        $profile->save();

                        $data = array(
                            'user_id' => $this->user->id,
                            'module' => 'users',
                            'module_id' => $user->id,
                            'action' => 'new',
                            'message' => '',
                        );
                        ORM::factory('Protocol')->write($data);

                    }
                    else {
                        $content->errors = $profile->validate()->errors('validate');
                    }
                }
                Request::instance()->redirect('admin/users');
            }
            else {
                $content->errors = $user->validate()->errors('validate');
            }
        }
        $content->user = $user;
        $content->profile = $profile;
        $content->languages = ORM::factory('Language')->find_all()->as_array('locale', 'title');
        $content->genders = array('m' => __('Male'), 'f' => __('Female'));
    }

    public function action_edit($id) {
        $this->template->title = __('Edit user');
        $content = $this->template->content = View::factory('admin/users/edit');

        $user = ORM::factory('User')->find($id);
        $profile = $user->profiles->where('user_id','=',$user->id)->find();

        if ($_POST) {
            if (empty($_POST['password'])) {
                $password = $user->password;
            }
            $user->values($_POST);
            if ($user->check()) {
                $user->save();
                if (isset($password)) {
                    DB::update('users')->set(array('password' => $password))->execute();
                }
                if ($user->saved()) {
                    $_POST['user_id'] = $user->id;
                    $profile->values($_POST);
                    if ($profile->check()) {
                        $profile->save();

                        $data = array(
                            'user_id' => $this->user->id,
                            'module' => 'users',
                            'module_id' => $user->id,
                            'action' => 'edit',
                            'message' => '',
                        );
                        ORM::factory('Protocol')->write($data);

                    }
                    else {
                        $content->errors = $profile->validate()->errors('validate');
                    }
                }
                Request::instance()->redirect('admin/users');
            }
            else {
                $content->errors = $user->validate()->errors('validate');
            }
        }
        $content->user = $user;
        $content->profile = $profile;
        $content->languages = ORM::factory('Language')->find_all()->as_array('locale', 'title');
        $content->genders = array('m' => __('Male'), 'f' => __('Female'));
    }

    public function action_delete($id) {
        if ($this->user->id != $id) {
            ORM::factory('Profile')->where('user_id','=',$id)->delete();
            ORM::factory('User')->delete($id);

            $data = array(
                'user_id' => $this->user->id,
                'module' => 'users',
                'module_id' => $id,
                'action' => 'delete',
                'message' => '',
            );
            ORM::factory('Protocol')->write($data);

        }
        Request::instance()->redirect('admin/users');
    }

    public function action_roles($id) {
        $this->template->title = __('User roles');
        $content = $this->template->content = View::factory('admin/users/roles');
        $user = ORM::factory('User')->find($id);
        $role = ORM::factory('Role');
        
        if ($_POST AND isset($_POST['user_roles'])) {
            foreach($role->find_all() AS $r) {
                $has = $user->has('roles', $r);
                if ( ! $has AND in_array($r->id, $_POST['user_roles'])) {
                    $user->add('roles', $r);
                }
                if ($has AND ! in_array($r->id, $_POST['user_roles'])) {
                    $user->remove('roles', $r);
                }
            }
            Request::instance()->redirect('admin/users');
        }

        $user_roles = $user->roles->find_all()->as_array('id', 'name');
        $roles = $role->find_all()->as_array('id', 'name');

        $content->user = $user;
        $content->profile = $user->profiles->find();
        $content->user_roles = $user_roles;
        foreach ($user_roles AS $k => $v) { unset($roles[$k]); }
        $content->roles = $roles;
        $content->select_attr = array(
            'size' => 5,
            'style' => 'width:200px;',
            'multiple' => 'multiple'
        );
    }

}

// End Application
