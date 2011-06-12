<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ajax extends Controller {

    public function action_viewcomment($id) {
        $comment = ORM::factory('Comment')->find($id);
        $this->request->response = '<div class="block500">'.$comment->comment.'</div>';
    }

    public function action_reference($id) {
        $reference = ORM::factory('Reference')->find($id);
        $this->request->response = '<div class="block500">'.$reference->reference_text.'</div>';
    }

    public function action_viewpage($id, $locale = FALSE) {
        if ( ! $locale)
            $language = ORM::factory('Language')->get_default();
        else
            $language = ORM::factory('Language')->get_id_by_locale($locale);

        $page = DB::select('pages.*', 'contents.*', 'titles.*')
                ->from('pages')
                ->join('contents', 'LEFT')
                ->on('pages.id','=','contents.page_id')
                ->join('titles', 'LEFT')
                ->on('pages.id','=','titles.page_id')
                ->where('pages.id','=',$id)
                ->and_where('contents.language_id','=',$language->id)
				->and_where('titles.language_id','=',$language->id)
                ->as_object(TRUE)
                ->execute();
        if ($page->count()) {
            $page = $page->current();
            $content = View::factory('admin/pages/view', array('data' => $page));
        }
        else {
            $content = '<div class="block500">'.HTML::flash_message(__('No page found!'), HTML::WARNING).'</div>';
        }
        $this->request->response = $content;
    }

    public function action_viewuser($id) {
        $user = ORM::factory('User')->find($id);
        if ($user->loaded()) {
            $profile = $user->profiles->where('user_id','=',$user->id)->find();
            $content = View::factory('admin/users/view',
                    array('user' => $user, 'profile' => $profile));
        }
        else {
            $content = '<div class="block500">'.HTML::flash_message(__('No user found!'), HTML::WARNING).'</div>';
        }
        $this->request->response = $content;
    }

    public function action_loadpages($id, $language) {
        $pages = ORM::factory('Page')->get_child_pages($id, $language);
        if ($pages->count()) {
            $content = View::factory('admin/pages/block');
            $content->pages = $pages;
            $content->language = ORM::factory('Language')->find($language);
            $this->request->response = $content->render();
        }
        else {
            $this->request->response = 'false';
        }
    }

    public function action_upload($type = FALSE) {
        $config = Kohana::config('application');
        $photos_extensions = $config->image_extensions;
        $document_extension = $config->document_extension;
        $size_limit = $config->size_limit;
        $upload_dir = $config->tmp_upload_dir;

        $allowed_extensions = Arr::merge($photos_extensions, $document_extension);
        
        $uploader = new Uploader($allowed_extensions, $size_limit);
        $result = $uploader->handleUpload($upload_dir);
        
        if (in_array($result['extension'], $photos_extensions)) {
            $result['type'] = 'photos';
        } elseif (in_array($result['extension'], $document_extension)) {
            $result['type'] = 'documents';
        }

        $this->request->response = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }

    public function action_deletemedia($id) {
        $result = 'false';
        $file = ORM::factory('Media')->find($id);
        if ($file->loaded()) {
            if (unlink($file->path.DS.$file->filename.'.'.$file->extension)) {
                $file->delete();
                $result = 'true';
            }
        }
        $this->request->response = $result;
    }

    public function action_loadoptions($module = 'category') {
        $result = ORM::factory($module)->find_all();
        if ($result) {
            $options = '<option value="0">---</option>';
            foreach ($result AS $item) {
                $options .= '<option value="'.$item->id.'">'.$item->title.'</option>';
            }
            $this->request->response = $options;
        } else {
            $this->request->response = 'false';
        }
    }
	
    public function action_pagelist($language_id = 1) {
        $content = '';
        $pages = ORM::factory('Page')->get_page_list($language_id);
        if (count($pages) > 0) {
            foreach ($pages AS $k => $v) {
                $content .= '<option value="'.$k.'">'.$v.'</option>';
            }
        } else {
            $content = 'false';
        }
        $this->request->response = $content;
    }

}

// End Application
