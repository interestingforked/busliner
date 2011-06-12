<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_News extends Controller_Admin_Application {

    public $secure_actions = array(
        'index' => array('editor'),
        'new' => array('editor'),
        'edit' => array('editor'),
        'status' => array('editor'),
        'delete' => array('admin'),
    );

    public function action_index() {
        $this->template->title = __('News');
        $content = $this->template->content = View::factory('admin/news/index');
        $count = ORM::factory('News')->count_all();
        $pagination = Pagination::factory(array('total_items' => $count));
        $news = ORM::factory('News')
            ->select('news.*', 'languages.locale')
            ->join('languages', 'LEFT')
            ->on('news.language_id', '=', 'languages.id')
            ->order_by('created', 'DESC')
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();
        $content->news = $news;
        $content->page_links = $pagination->render();
    }

    public function action_new() {
        $this->template->title = __('Add new article');
        $content = $this->template->content = View::factory('admin/news/edit');

        $content->categories = ORM::factory('Category')->find_all()->as_array('id', 'title');
        $content->languages = ORM::factory('Language')->find_all()->as_array('id', 'title');
        $content->status = array('draft' => __('Draft'), 'published' => __('Published'),);
        $article = ORM::factory('News');
        if ($_POST) {
            $_POST['slug'] = Text::slugify($_POST['title']);
			$_POST['created'] = (!empty($_POST['created'])) ? $_POST['created'] : DB::expr('NOW()');
            $_POST['created_by'] = $this->user->id;
            if (empty($_POST['body'])) {
                $_POST['body'] = '&nbsp;';
            }
            $values = $_POST;

            if (isset($_POST['actual']) AND $_POST['actual'] == 1) {
                $news = ORM::factory('News');
                $news->actual = 0;
                $news->where('actual', '=', '1')->save_all();
            }
            if (isset($_POST['new']) AND $_POST['new'] == 1) {
                $news = ORM::factory('News');
                $news->new = 0;
                $news->where('new', '=', '1')->save_all();
            }
            if (isset($_POST['competition']) AND $_POST['competition'] == 1) {
                $news = ORM::factory('News');
                $news->competition = 0;
                $news->where('competition', '=', '1')->save_all();
            }

            $media_array = array();
            foreach ($_POST AS $k => $v) {
                if (preg_match('/(photo|document)([0-9]+)/i', $k)) {
                    $media_array[] = $v;
                }
            }

            $article->values($_POST);
            if ($article->check()) {
                $article->save();

                if (count($media_array) > 0) {
                    $media = ORM::factory('Media')->save_media_files($media_array, 'news', $article->id, $article->slug, $this->user);
                    if (is_array($media)) {
                        $content->errors = $media;
                    }
                }

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'news',
                    'module_id' => $article->id,
                    'action' => 'create',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                if (isset($values['event']) AND $values['event'] == 1) {
                    $event = ORM::factory('Event');
                    $event->values($values);
                    $event->start_date = $values['start_date'];
					$event->end_date = $values['start_date'];
                    $event->save();
                    $data = array(
                        'user_id' => $this->user->id,
                        'module' => 'events',
                        'module_id' => $event->id,
                        'action' => 'create',
                        'message' => '',
                    );
                    ORM::factory('Protocol')->write($data);
                }

                Request::instance()->redirect('admin/news');
            } else {
                $content->errors = $article->validate()->errors('validate');
            }
        }
        $content->values = $article;
    }

    public function action_edit($id) {
        $this->template->title = __('Edit article');
        $content = $this->template->content = View::factory('admin/news/edit');

        $content->categories = ORM::factory('Category')->find_all()->as_array('id', 'title');
        $content->languages = ORM::factory('Language')->find_all()->as_array('id', 'title');
        $content->status = array('draft' => __('Draft'), 'published' => __('Published'),);
        $article = ORM::factory('News')->find($id);
        if ($_POST) {
            $_POST['slug'] = Text::slugify($_POST['title']);
            $_POST['updated'] = DB::expr('NOW()');
			$_POST['created'] = (!empty($_POST['created'])) ? $_POST['created'] : DB::expr('NOW()');
            $_POST['updated_by'] = $this->user->id;
            $_POST['dontshow'] = Arr::get($_POST, 'dontshow', 0);
            $_POST['new'] = Arr::get($_POST, 'new', 0);
            $_POST['actual'] = Arr::get($_POST, 'actual', 0);
            $_POST['competition'] = Arr::get($_POST, 'competition', 0);
            $_POST['rss_enabled'] = Arr::get($_POST, 'rss_enabled', 0);
            $_POST['comments_enabled'] = Arr::get($_POST, 'comments_enabled', 0);
            if (empty($_POST['body'])) {
                $_POST['body'] = '&nbsp;';
            }

            if (isset($_POST['actual']) AND $_POST['actual'] == 1) {
                $news = ORM::factory('News');
                $news->actual = 0;
                $news->where('actual', '=', '1')->save_all();
            }
            if (isset($_POST['new']) AND $_POST['new'] == 1) {
                $news = ORM::factory('News');
                $news->new = 0;
                $news->where('new', '=', '1')->save_all();
            }
            if (isset($_POST['competition']) AND $_POST['competition'] == 1) {
                $news = ORM::factory('News');
                $news->competition = 0;
                $news->where('competition', '=', '1')->save_all();
            }

            $media_array = array();
            foreach ($_POST AS $k => $v) {
                if (preg_match('/(photo|document)([0-9]+)/i', $k)) {
                    $media_array[] = $v;
                }
            }

            $article->values($_POST);
            if ($article->check()) {
                $article->save();

                if (count($media_array) > 0) {
                    $media = ORM::factory('Media')->save_media_files($media_array, 'news', $article->id, $article->slug, $this->user);
                    if (is_array($media)) {
                        $content->errors = $media;
                    }
                }

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'news',
                    'module_id' => $article->id,
                    'action' => 'edit',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                if (isset($values['event']) AND $values['event'] == 1) {
                    $event = ORM::factory('Event')->where('slug', '=', $article->slug)->find();
                    if (!$event->loaded()) {
                        $event = ORM::factory('Event');
                        $event->values($values);
                        $event->start_date = $values['start_date'];
						$event->end_date = $values['start_date'];
                        $event->save();
                        $data = array(
                            'user_id' => $this->user->id,
                            'module' => 'events',
                            'module_id' => $event->id,
                            'action' => 'create',
                            'message' => '',
                        );
                        ORM::factory('Protocol')->write($data);
                    }
                }

                Request::instance()->redirect('admin/news');
            } else {
                $content->errors = $article->validate()->errors('validate');
            }
        }
        $content->values = $article;
        $content->photos = ORM::factory('Media')->get_media('news', $article->id, 'photo');
        $content->documents = ORM::factory('Media')->get_media('news', $article->id, 'document');
    }

    public function action_delete($id) {
        $article = ORM::factory('News')->find($id);

        ORM::factory('Media')
            ->where('module','=','news')
            ->and_where('module_id','=',$article->id)
            ->delete_all();

        $article->delete();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'news',
            'module_id' => $id,
            'action' => 'create',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/news');
    }

    public function action_status($id) {
        $news = ORM::factory('News')->find($id);
        $status = $news->status;
        if ($status == 'published') {
            $news->status = 'draft';
        } else {
            $news->status = 'published';
        }
        $news->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'news',
            'module_id' => $news->id,
            'action' => 'status_change',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/news');
    }

}

// End Application
