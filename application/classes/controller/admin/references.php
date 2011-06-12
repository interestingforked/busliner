<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_References extends Controller_Admin_Application {

    public $secure_actions = array(
        'index' => array('editor'),
        'approved' => array('editor'),
        'approve' => array('editor'),
        'unapprove' => array('editor'),
        'delete' => array('admin'),
    );

    public function action_index() {
        $this->template->title = __('References');
        $content = $this->template->content = View::factory('admin/references/index');
        $count = ORM::factory('Reference')->where('active','=','0')->count_all();
        $pagination = Pagination::factory(array('total_items' => $count));
        $references = ORM::factory('Reference')
            ->where('active','=','0')
            ->order_by('created','DESC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();
        $content->references = $references;
        $content->page_links = $pagination->render();
    }

    public function action_view($id) {
        $this->template->title = __('Reference');
        $content = $this->template->content = View::factory('admin/references/view');
        $reference = ORM::factory('Reference')->find($id);
        $content->reference = $reference;
    }
    
    public function action_edit($id) {
        $this->template->title = __('Reference');
        $content = $this->template->content = View::factory('admin/references/edit');
        $reference = ORM::factory('Reference')->find($id);
        if ($_POST) {
            $reference->values($_POST);
            if ($reference->check()) {
                $reference->save();
                
                $this->cacheinstance->delete_all();
                if ($reference->active) {
                    Request::instance()->redirect('admin/references/approved');
                } else {
                    Request::instance()->redirect('admin/references');
                }
            }
        }
        $content->reference = $reference;
    }

    public function action_approved() {
        $this->template->title = __('References');
        $content = $this->template->content = View::factory('admin/references/approved');
        $count = ORM::factory('Reference')->where('active','=','0')->count_all();
        $pagination = Pagination::factory(array('total_items' => $count));
        $references = ORM::factory('Reference')
            ->where('active','=','1')
            ->order_by('created','DESC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();
        $content->references = $references;
        $content->page_links = $pagination->render();
    }

    public function action_approve($id) {
        $comment = ORM::factory('Reference')->find($id);
        $comment->active = 1;
        $comment->approved = DB::expr('NOW()');
        $comment->save();

        $this->cacheinstance->delete_all();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'references',
            'module_id' => $id,
            'action' => 'approve',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/references');
    }

    public function action_unapprove($id) {
        $comment = ORM::factory('Reference')->find($id);
        $comment->active = 0;
        $comment->save();

        $this->cacheinstance->delete_all();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'references',
            'module_id' => $id,
            'action' => 'unapprove',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/references/approved');
    }

    public function action_delete($id) {
        ORM::factory('Reference')->delete($id);

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'references',
            'module_id' => $id,
            'action' => 'delete',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);
        
        if ($this->referer) {
                Request::instance()->redirect($this->referer);
        } else {
                Request::instance()->redirect('admin/references');
        }
 
    }

}

// End Application
