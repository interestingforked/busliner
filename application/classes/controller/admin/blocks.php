<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Blocks extends Controller_Admin_Application {

    public $secure_actions = array(
        'index' => array('editor'),
        'new' => array('editor'),
        'edit' => array('editor'),
        'status' => array('editor'),
        'moveup' => array('editor'),
        'movedown' => array('editor'),
        'delete' => array('admin'),
    );

    public function action_index() {
        $this->template->title = __('Blocks');
        $content = $this->template->content = View::factory('admin/blocks/index');
        $blocks = ORM::factory('Block')->order_by('type')->order_by('position')->find_all();
        $content->blocks = $blocks;
    }

    public function action_new() {
        $this->template->title = __('Add block');
        $content = $this->template->content = View::factory('admin/blocks/edit');
        $block = ORM::factory('Block');
        if ($_POST) {
            if (!$_POST['position']) {
                $position = ORM::factory('Block')
                    ->select(array(DB::expr('MAX(`position`)'), 'max_position'), 'id')
                    ->where('type', '=', Arr::get($_POST, 'type'))
                    ->group_by('id')
                    ->order_by('max_position', 'DESC')
                    ->find();
                if ($position->loaded()) {
                    $_POST['position'] = $position->max_position;
                } else {
                    $_POST['position'] = 0;
                }
            }
            $_POST['content'] = $_POST['body'];
            $block->values($_POST);
            if ($block->check()) {
                $block->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'blocks',
                    'module_id' => $block->id,
                    'action' => 'create',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/blocks');
            } else {
                $content->errors = $block->validate()->errors('validate');
            }
        }
        $content->block = $block;
        $content->types = Kohana::config('application')->block_types;
        $content->plugins = Kohana::config('application')->plugins;
        $languages = ORM::factory('Language')->find_all()->as_array('id', 'title');
        array_unshift($languages, __('All'));
        $content->languages = $languages;
    }

    public function action_edit($id) {
        $this->template->title = __('Edit layouts');
        $content = $this->template->content = View::factory('admin/blocks/edit');
        $block = ORM::factory('Block')->find($id);
        if ($_POST) {
            $_POST['show_title'] = Arr::get($_POST, 'show_title', 0);
            $_POST['position'] = Arr::get($_POST, 'position', $block->position);
            $_POST['content'] = $_POST['body'];
            $block->values($_POST);
            if ($block->check()) {
                $block->save();

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'blocks',
                    'module_id' => $block->id,
                    'action' => 'edit',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                Request::instance()->redirect('admin/blocks');
            } else {
                $content->errors = $block->validate()->errors('validate');
            }
        }
        $content->block = $block;
        $content->types = Kohana::config('application')->block_types;
        $content->plugins = Kohana::config('application')->plugins;
        $languages = ORM::factory('Language')->find_all()->as_array('id', 'title');
        array_unshift($languages, __('All'));
        $content->languages = $languages;
    }

    public function action_delete($id) {
        ORM::factory('Block')->delete($id);

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'blocks',
            'module_id' => $id,
            'action' => 'create',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/blocks');
    }

    public function action_moveup($id) {
        $block = ORM::factory('Block')->find($id);
        $position = $block->position;
        if ($position > 1) {
            $upper = ORM::factory('Block')
                ->where('position', '=', ($block->position - 1))
                ->and_where('type', '=', $block->type)
                ->find();
            if (count($upper) > 0) {
                $block->position = $upper->position;
                $block->save();
                $upper->position = $position;
                $upper->save();
            }
        }
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'blocks',
            'module_id' => $block->id,
            'action' => 'moved up',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/blocks');
    }

    public function action_movedown($id) {
        $block = ORM::factory('Block')->find($id);
        $position = $block->position;
        $max = ORM::factory('Block')
            ->select(array(DB::expr('MAX(`position`)'), 'max_position'), 'id')
            ->where('type', '=', $block->type)
            ->group_by('id')
            ->order_by('max_position', 'DESC')
            ->find()
                ->max_position;
        if ($position < $max) {
            $upper = ORM::factory('Block')
                ->where('position', '=', ($block->position + 1))
                ->and_where('type', '=', $block->type)
                ->find();
            if (count($upper) > 0) {
                $block->position = $upper->position;
                $block->save();
                $upper->position = $position;
                $upper->save();
            }
        }
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'blocks',
            'module_id' => $block->id,
            'action' => 'moved down',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/blocks');
    }

    public function action_status($id) {
        $block = ORM::factory('Block')->find($id);
        $status = $block->active;
        if ($status == 1) {
            $block->active = 0;
        } else {
            $block->active = 1;
        }
        $block->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'blocks',
            'module_id' => $block->id,
            'action' => 'status_change',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/blocks');
    }

}

// End Application
