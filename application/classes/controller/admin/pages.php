<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin_Application {

    public $secure_actions = array(
        'index' => array('editor'),
        'deleted' => array('editor'),
        'new' => array('editor'),
        'edit' => array('editor'),
        'status' => array('editor'),
        'moveup' => array('editor'),
        'movedown' => array('editor'),
        'delete' => array('admin'),
        'remove' => array('admin'),
        'restore' => array('admin'),
    );

    public function action_index($locale = FALSE, $id = FALSE) {
        $this->template->title = __('Pages');
        $content = $this->template->content = View::factory('admin/pages/index');
        if (!$locale)
            $language = ORM::factory('Language')->get_default();
        else
            $language = ORM::factory('Language')->get_id_by_locale($locale);

        $pages = ORM::factory('Page')->get_child_pages(0, $language->id);
        $page = View::factory('admin/pages/block');
        $page->pages = $pages;
        $page->language = ORM::factory('Language')->find($language);
        if ($id) {
            $opened = ORM::factory('Page')->find($id);
            if ($opened->parent_id > 0) {
                $opened2 = ORM::factory('Page')->find($opened->parent_id);
                if ($opened2->parent_id > 0) {
                    $opened = $opened2;
                }
            }
            $page->open = array(
                'language' => $language->id,
                'page' => (($opened->parent_id > 0) ? $opened->parent_id : $id),
            );
        }
        $content->results = count($pages);
        $content->pages = $page;
        $content->languages = ORM::factory('Language')->find_all();

        
    }

    public function action_new($id = FALSE) {
        $this->template->title = __('Add page');
        $content = $this->template->content = View::factory('admin/pages/edit');

        $content->pages = ORM::factory('Page')->get_page_list();
        $languages = ORM::factory('Language')
            ->find_all()
            ->as_array('id', 'title');

        if ($id) {
            $page = ORM::factory('Page')->find($id);
            $tmptitles = $page->titles->find_all();
            foreach ($tmptitles AS $tmptitle) {
                unset($languages[$tmptitle->language_id]);
            }
        } else {
            $page = ORM::factory('Page');
        }

        $content->languages = $languages;
        $content->errors = array();
        $content->translation = ($id) ? array('disabled' => 'disabled') : array();

        $page_content = ORM::factory('Content');
        $page_title = ORM::factory('Title');
        if ($_POST) {
            $ok = TRUE;
            $errors = array();
            if ($_POST['parent_id'] > 0 AND $_POST['parent_id'] == $id) {
                $ok = FALSE;
                $content->errors[] = __('Parent page cannot be the same as this page!');
            }
            if (!$_POST['slug']) {
                $_POST['slug'] = Text::slugify($_POST['title']);
            }
            $et = ORM::factory('Title')->where('slug', '=', $_POST['slug'])->find();
            if ($et->loaded()) {
                $ok = FALSE;
                $content->errors[] = __('Page is exist!');
            }
            if (!$id) {
                $_POST['position'] = $page->get_new_position($_POST['parent_id']);
            }
            $_POST['created'] = DB::expr('NOW()');
            $_POST['created_by'] = $this->user->id;
            
            if (empty($_POST['body'])) {
                $_POST['body'] = '&nbsp;';
            }

            if (empty($_POST['content_title'])) {
                $_POST['content_title'] = $_POST['title'];
            }

            if ($_POST['parent_id'] > 0) {
                $parent_id = $_POST['parent_id'];
                $slugs = array();
                while ($parent_id != 0) {
                    $slugpage = ORM::factory('Page')->link($parent_id, $_POST['language_id']);
                    if ($slugpage) {
                        $slugs[] = $slugpage->slug;
                        $parent_id = $slugpage->parent_id;
                    }
                }
                $slugs[] = $_POST['slug'];
                $_POST['long_slug'] = implode('/', $slugs);
            }

            $media_array = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/(photo|document)([0-9]+)/i', $k)) {
                    $media_array[] = $v;
                }
            }
            
            if ($_POST['module'] == 'files') {
                $directory = str_replace('/', '_', $_POST['long_slug']);
            }

            $content_post = $_POST;
            $title_post = $_POST;
            $page->values($_POST);
            if ($page->check()) {
                if ($ok) {
                    $page->save();
                }
                if ($page->saved()) {
                    $content_post['page_id'] = $page->id;
                    $title_post['page_id'] = $page->id;

                    $page_title->values($title_post);
                    if ($page_title->check()) {
                        $page_title->save();
                        if ($page_title->saved()) {
                            $page_content->values($content_post);
                            if ($page_content->check()) {
                                $page_content->save();
                            } else {
                                $page->delete();
                                $page_title->delete();
                                $content->errors = Arr::merge($content->errors, $page_content->validate()->errors('validate'));
                            }
                        } else {
                            $page->delete();
                            $content->errors = Arr::merge($content->errors, $page_title->validate()->errors('validate'));
                        }
                    }
                    if (count($media_array) > 0) {
                        $media = ORM::factory('Media')->save_media_files($media_array, 'pages', $page->id, $page_title->slug, $this->user);
                        if (is_array($media)) {
                            $content->errors = $media;
                        }
                    }
                    if (isset($directory)) {
                        if ( ! file_exists($this->config->downloads_uploads.$directory)) {
                            mkdir($this->config->downloads_uploads.$directory, 755);
                        }
                    }
                }
            } else {
                $content->errors = Arr::merge($content->errors, $page->validate()->errors('validate'));
            }
            if (empty($content->errors)) {

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'pages',
                    'module_id' => $page->id,
                    'action' => 'create',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);


                $current_language = ORM::factory('Language')->find($_POST['language_id']);
                Request::instance()->redirect('admin/pages/index/' . $current_language->locale . '/' . $page->id);
            }
        }
        $content->page = $page;
        $content->content = $page_content;
        $content->title = $page_title;
        $content->media = ORM::factory('Media')->get_media('pages', $page->id);
        $content->modules = Kohana::config('application')->modules;
        $content->modules_list = '';
    }

    public function action_edit($id, $language_id) {
        $this->template->title = __('Edit page');
        $content = $this->template->content = View::factory('admin/pages/edit');

        $content->pages = ORM::factory('Page')->get_page_list();
        $content->languages = ORM::factory('Language')
            ->find_all()
            ->as_array('id', 'title');
        $content->translation = array();

        $page = ORM::factory('Page')->find($id);
        $page_content = $page->contents->where('language_id', '=', $language_id)->find();
        $page_title = $page->titles->where('language_id', '=', $language_id)->find();
        if ($_POST) {
            $ok = TRUE;
            $errors = array();
            if ($_POST['parent_id'] == $id) {
                $ok = FALSE;
                $errors[] = __('Parent page cannot be the same as this page!');
            }
            if (!$_POST['slug']) {
                $_POST['slug'] = Text::slugify($_POST['title']);
            }
            $_POST['updated'] = DB::expr('NOW()');
            $_POST['updated_by'] = $this->user->id;
            $_POST['rss_enabled'] = Arr::get($_POST, 'rss_enabled', 0);
            $_POST['comments_enabled'] = Arr::get($_POST, 'comments_enabled', 0);
            if (empty($_POST['content_title'])) {
                $_POST['content_title'] = $_POST['title'];
            }
            if (empty($_POST['body'])) {
                $_POST['body'] = '&nbsp;';
            }

            if ($_POST['parent_id'] > 0) {
                $parent_id = $_POST['parent_id'];
                $slugs = array();
                while ($parent_id != 0) {
                    $slugpage = ORM::factory('Page')->link($parent_id, $_POST['language_id']);
                    if ($slugpage) {
                        $slugs[] = $slugpage->slug;
                        $parent_id = $slugpage->parent_id;
                    }
                }
                $slugs = array_reverse($slugs);
                $slugs[] = $_POST['slug'];
                $_POST['long_slug'] = implode('/', $slugs);
            }

            $media_array = array();
            foreach ($_POST AS $k => $v) {
                $k = str_replace('qq-upload-handler-iframe', '', $k);
                if (preg_match('/(photo|document)([0-9]+)/i', $k)) {
                    $media_array[] = $v;
                }
            }
            
            if ($_POST['module'] == 'files') {
                $directory = str_replace('/', '_', $_POST['long_slug']);
            }

            $content_post = $_POST;
            $title_post = $_POST;
            $page->values($_POST);
            if ($page->check() AND $ok) {
                $page->save();

                if ($page->saved()) {
                    $content_post['page_id'] = $page->id;
                    $title_post['page_id'] = $page->id;

                    $page_title->values($title_post);
                    if ($page_title->check()) {
                        $page_title->save();
                        if ($page_title->saved()) {
                            $page_content->values($content_post);
                            if ($page_content->check()) {
                                $page_content->save();
                            } else {
                                $content->errors = $page_content->validate()->errors('validate');
                            }
                            if (count($media_array) > 0) {
                                $media = ORM::factory('Media')->save_media_files($media_array, 'pages', $page->id, $page_title->slug, $this->user);
                                if (is_array($media)) {
                                    $content->errors = $media;
                                }
                            }
                            if (isset($directory)) {
                                if ( ! file_exists($this->config->downloads_uploads.$directory)) {
                                    mkdir($this->config->downloads_uploads.$directory, 755);
                                }
                            }
                        } else {
                            $content->errors = $page_title->validate()->errors('validate');
                        }
                    }
                }
            } else {
                $content->errors = Arr::merge($errors, $page->validate()->errors('validate'));
            }
            if (empty($content->errors)) {

                $data = array(
                    'user_id' => $this->user->id,
                    'module' => 'pages',
                    'module_id' => $page->id,
                    'action' => 'edit',
                    'message' => '',
                );
                ORM::factory('Protocol')->write($data);

                $current_language = ORM::factory('Language')->find($_POST['language_id']);
                Request::instance()->redirect('admin/pages/index/' . $current_language->locale . '/' . $page->id);
            }
        }

        $module_categories = '';
        if ($page->module_id > 0) {
            $categories = ORM::factory('Category')->find_all();
            foreach ($categories AS $category) {
                $module_categories .= '<option value="' . $category->id . '" ' . (($page->module_id == $category->id) ? 'selected' : '') . '>' . $category->title . '</option>';
            }
        }
        $content->modules_list = $module_categories;

        $content->page = $page;
        $content->content = $page_content;
        $content->title = $page_title;
        $content->photos = ORM::factory('Media')->get_media('pages', $page->id, 'photo');
        $content->documents = ORM::factory('Media')->get_media('pages', $page->id, 'document');
        $content->modules = Kohana::config('application')->modules;
    }

    public function action_delete($id) {
        $page = ORM::factory('Page')->find($id);
        $page->status = 'deleted';
        $page->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'pages',
            'module_id' => $page->id,
            'action' => 'status_deleted',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/pages');
    }

    public function action_delete_language($id, $language_id) {
        $count = ORM::factory('Title')
            ->where('page_id','=',$id)
            ->count_all();
        
        if ($count > 1) {
            $title = ORM::factory('Title')
                ->where('page_id','=',$id)
                ->and_where('language_id','=',$language_id)
                ->find();
            $title->delete();

            $content = ORM::factory('Content')
                ->where('page_id','=',$id)
                ->and_where('language_id','=',$language_id)
                ->find();
            $content->delete();
        }

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'pages',
            'module_id' => $id,
            'action' => 'language_delete',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        $language = ORM::factory('language')->get_default();
        Request::instance()->redirect('admin/pages/index/'.$language->locale.'/'.$id);
    }

    public function action_remove($id) {
        $page = ORM::factory('Page')->find($id);
        $page->titles->where('page_id','=',$page->id)->delete_all();
        $page->contents->where('page_id','=',$page->id)->delete_all();

        ORM::factory('Media')
            ->where('module','=','pages')
            ->and_where('module_id','=',$page->id)
            ->delete_all();

        $page->delete();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'pages',
            'module_id' => $page->id,
            'action' => 'deleted',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/pages/deleted');
    }

    public function action_restore($id) {
        $page = ORM::factory('Page')->find($id);
        $page->status = 'draft';
        $page->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'pages',
            'module_id' => $page->id,
            'action' => 'restore',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        Request::instance()->redirect('admin/pages');
    }

    public function action_deleted() {
        $this->template->title = __('Deleted pages');
        $content = $this->template->content = View::factory('admin/pages/deleted');

        $pages = ORM::factory('Page')->where('status', '=', 'deleted')->find_all();

        $content->pages = $pages;
        $content->language = ORM::factory('Language')->get_default();

        $content->languages = ORM::factory('Language')->find_all();
    }

    public function action_status($id) {
        $page = ORM::factory('Page')->find($id);
        $status = $page->status;
        if ($status == 'published') {
            $page->status = 'draft';
        } else {
            $page->status = 'published';
        }
        $page->save();

        $data = array(
            'user_id' => $this->user->id,
            'module' => 'pages',
            'module_id' => $page->id,
            'action' => 'status_change',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);
		
        $language = ORM::factory('language')->get_default();
        Request::instance()->redirect('admin/pages/index/'.$language->locale.'/'.$page->id);
    }

    public function action_moveup($id) {
        $page = ORM::factory('Page')->find($id);
        $position = $page->position;
        if ($position > 1) {
            $upper_page = ORM::factory('Page')
                            ->where('parent_id', '=', $page->parent_id)
                            ->and_where('position', '=', ($page->position - 1))
                            ->find();
            if (count($upper_page) > 0) {
                $page->position = $upper_page->position;
                $page->save();
                $upper_page->position = $position;
                $upper_page->save();
            }
        }
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'pages',
            'module_id' => $page->id,
            'action' => 'moved up',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        $language = ORM::factory('language')->get_default();
        Request::instance()->redirect('admin/pages/index/'.$language->locale.'/'.$page->id);
    }

    public function action_movedown($id) {
        $page = ORM::factory('Page')->find($id);
        $position = $page->position;
        $max_position = ORM::factory('Page')
                        ->select(array(DB::expr('MAX(`position`)'), 'max_position'), 'id')
                        ->where('parent_id', '=', $page->parent_id)
                        ->group_by('id')
                        ->order_by('max_position', 'DESC')
                        ->find()
                ->max_position;
        if ($position < $max_position) {
            $upper_page = ORM::factory('Page')
                            ->where('parent_id', '=', $page->parent_id)
                            ->and_where('position', '=', ($page->position + 1))
                            ->find();
            if (count($upper_page) > 0) {
                $page->position = $upper_page->position;
                $page->save();
                $upper_page->position = $position;
                $upper_page->save();
            }
        }
        $data = array(
            'user_id' => $this->user->id,
            'module' => 'pages',
            'module_id' => $page->id,
            'action' => 'moved down',
            'message' => '',
        );
        ORM::factory('Protocol')->write($data);

        $language = ORM::factory('language')->get_default();
        Request::instance()->redirect('admin/pages/index/'.$language->locale.'/'.$page->id);
    }

}

// End Application
