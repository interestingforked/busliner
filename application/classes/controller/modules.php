<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Modules extends Controller {

    public $config;
    public $cache;
    public $cacheinstance;
    public $session;
    public $language;

    public function before() {
        parent::before();
        
        $this->config = Kohana::config('application');
        $this->session = Session::instance();
        $this->language = $this->session->get('language');

        $this->cache = $this->config->cache;
        if ($this->cache) {
            $this->cacheinstance = Cache::instance($this->config->cache_instance);
        }

    }

    public function action_feedback() {
        $content = View::factory('modules/feedback');
        $content->countries = (array) Kohana::config('countries');
        $content->uri = $this->request->uri;

        if (isset($this->request->post)) {
            $error = TRUE;
            $mail = Kohana::config('application')->email;
            $headers = "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: Feedback mail ({$_SERVER['SERVER_NAME']}) <{$mail}>\r\n";
            $subject = "New feedback mail ({$_SERVER['SERVER_NAME']})";
            $message = '';
            foreach ($_POST AS $key => $value) {
                $message .= "{$key}: {$value}<br>\r\n";
            }
            if (mail($mail, $subject, $message, $headers)) {
                $content->message = '<div class="success"><p>'.__('Contact form text').'</p></div>';
            } else {
                $content->message = '<div class="error"><p>'.__('Error! Please try to send one more time.').'</p></div>';
            }
        }
        
        $this->request->response = $content->render();
    }

    public function action_references($id = NULL) {
        $content = View::factory('modules/references/index');

        if ($this->cache) {
            $references = $this->cacheinstance->get('references', NULL);
            if ( ! $references) {
                $references = ORM::factory('Reference')->get_references();
                $this->cacheinstance->set('references', $references);
            }
        } else {
            $references = ORM::factory('Reference')->get_references();
        }

        $content->references = $references;

        $this->request->response = $content->render();
    }

    public function action_new_reference() {
        $content = View::factory('modules/references/new');
        $content->countries = (array) Kohana::config('countries');
        $content->uri = $this->request->uri;

        if (isset($this->request->post)) {
            $post = $this->request->post;
            $post['created'] = DB::expr('now()');
            $post['ip'] = $_SERVER['REMOTE_ADDR'];

            $reference = ORM::factory('Reference');
            $reference->values($post);
            if ($reference->check()) {
                if (isset($this->request->files)) {
                    $files = $this->request->files;
                    if (isset($files['reference_img'])) {
                        $file = $files['reference_img'];
                        $hash = md5($file['name'] . time());
                        $extension = explode('.', $file['name']);
                        $extension = end($extension);

                        $directory = Kohana::config('application')->references_uploads;
                        $filename = $hash.'.'.$extension;
                        Upload::save($file, $filename, $directory);

                        $reference->file = '/'.$directory.$filename;
                    }
                }
                $reference->save();
                $content->message = '<div class="success"><p>'.__('Your reference was saved').'</p></div>';
            } else {
                $content->message = '<div class="success"><p>'.__('Error! Please try to send one more time.').'</p></div>';
            }

        }

        $this->request->response = $content->render();
    }
    
    public function action_files() {
        $directory = str_replace('/', '_', substr($this->request->uri, 3));
        
        $files = array();
        $directories = '';
        if (count($_GET) > 0) {
            $directories = array_keys($_GET);
            $directories = $directories[0].DS;
            if (preg_match('/__\//', $directories)) {
                $directories = '';
            }
            $directory = $directory.'/'.$directories;
        }
        $directory = $this->config->downloads_uploads.$directory;
        $directory_content = scandir($directory);
        $fc = 0;
        $dc = 0;
        foreach ($directory_content AS $file) {
            if ($file == '.' OR $file == '..')
                continue;
            
            $file_info = array();
            
            $file_info['file'] = $file;
            $file_info['name'] = ucfirst($file);
            
            if (preg_match('/\./', $file)) {
                $extension = explode('.', $file);
                $extension = end($extension);
                $file_info['type'] = $extension;
                $fc++;
                $key = 'f'.$fc;
            } else {
                $file_info['type'] = 'dir';
                $dc++;
                $key = 'd'.$dc;
            }
            $file_info['size'] = filesize($directory.DS.$file);
            $file_info['date'] = date("d.m.Y", filemtime($directory.DS.$file));

            $files[$key] = $file_info;
        }
        ksort($files);
        
        $content = View::factory('modules/files');
        $content->uri = $this->request->uri;
        $content->directory = $directory;
        $content->directories = $directories;
        $content->files = $files;

        $this->request->response = $content->render();
    }
    
    public function action_news() {
        $uri = explode('/', $this->request->uri);
        $slug = end($uri);
        
        if (count($_GET) > 0) {
            $article_slug = array_keys($_GET);
            $article_slug = $article_slug[0];
            
            if ($this->cache) {
                if ( ! $category = $this->cacheinstance->get('category_'.$slug, NULL)) {
                    $category = ORM::factory('Category')->get_category_sql($slug);
                    $this->cacheinstance->set('category_'.$slug, $category);
                }
                if ( ! $article = $this->cacheinstance->get('article_'.$article_slug, NULL)) {
                    $article = ORM::factory('News')->get_news_sql($category->id, $this->language->id, $article_slug);
                    $this->cacheinstance->set('article_'.$article_slug, $article);
                }
                if ( ! $documents = $this->cacheinstance->get('documents_'.$article_slug, NULL)) {
                    $documents = ORM::factory('Media')->get_media_sql('news', $article->id, 'document');
                    $this->cacheinstance->set('documents_'.$article_slug, $documents);
                }
            } else {
                $category = ORM::factory('Category')->get_category_sql($slug);
                $article = ORM::factory('News')->get_news_sql($category->id, $this->language->id, $article_slug);
                $documents = ORM::factory('Media')->get_media_sql('news', $article->id, 'document');
            }
            $content = View::factory('modules/news/view');
            $content->article = $article;
            $content->documents = $documents;
            
            $this->session->set('page_title', $article->title);
            
        } else {
            if ($this->cache) {
                if ( ! $category = $this->cacheinstance->get('category_'.$slug, NULL)) {
                    $category = ORM::factory('Category')->get_category_sql($slug);
                    $this->cacheinstance->set('category_'.$slug, $category);
                }
                if ( ! $news = $this->cacheinstance->get('news_'.$category->id, NULL)) {
                    $news = ORM::factory('News')->get_news_sql($category->id, $this->language->id);
                    $this->cacheinstance->set('news_'.$category->id, $news);
                }
            } else {
                $category = ORM::factory('Category')->get_category_sql($slug);
                $news = ORM::factory('News')->get_news_sql($category->id, $this->language->id);
            }
            $content = View::factory('modules/news/index');
            $content->news = $news;
        }

        $content->uri = $this->request->uri;

        $this->request->response = $content->render();
    }

}