<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Comments extends Controller_Admin_Application {

    public $secure_actions = array(
        'index' => array('editor'),
        'approved' => array('editor'),
        'approve' => array('editor'),
        'unapprove' => array('editor'),
        'delete' => array('admin'),
    );

    public function action_index() {
        $this->template->title = __('Comments');
        $content = $this->template->content = View::factory('admin/comments/index');
        $count = ORM::factory('Comment')->where('active','=','0')->count_all();
        $pagination = Pagination::factory(array('total_items' => $count));
        $comments = ORM::factory('Comment')
            ->where('active','=','0')
            ->order_by('created','ASC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();
        $content->comments = $comments;
        $content->page_links = $pagination->render();
    }

    public function action_approved() {
        $this->template->title = __('Comments');
        $content = $this->template->content = View::factory('admin/comments/approved');
        $count = ORM::factory('Comment')->where('active','=','1')->count_all();
        $pagination = Pagination::factory(array('total_items' => $count));
        $comments = ORM::factory('Comment')
            ->where('active','=','1')
            ->order_by('created','ASC')
            ->limit($pagination->items_per_page)
            ->find_all();
        $content->comments = $comments;
        $content->page_links = $pagination->render();
    }

    public function action_approve($id) {
        $comment = ORM::factory('Comment')->find($id);
        $comment->active = 1;
        $comment->approved = DB::expr('NOW()');
        $comment->approved_by = $this->user->id;
        $comment->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'comments',
            'module_id' => $id,
            'action' => 'approve',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/comments');
    }

    public function action_unapprove($id) {
        $comment = ORM::factory('Comment')->find($id);
        $comment->active = 0;
        $comment->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'comments',
            'module_id' => $id,
            'action' => 'unapprove',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/comments/approved');
    }

    public function action_delete($id) {
        ORM::factory('Comment')->delete($id);

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'comments',
            'module_id' => $id,
            'action' => 'delete',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

		if ($this->referer) {
			Request::instance()->redirect($this->referer);
		} else {
			Request::instance()->redirect('admin/comments');
		}
  
    }

}

// End Application
