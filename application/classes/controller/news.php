<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Application {

    public function action_index($slug = FALSE) {
        $content = $this->template->content = View::factory('news/index');

        if ($slug) {
            $category = ORM::factory('Category')->where('slug', '=', $slug)->find();
            $count = $category->news
                ->where('status', '=', 'published')
                ->and_where('competition', '!=', 1)
                ->and_where('dontshow', '=', 0)
                ->and_where('language_id', '=', $this->language->id)
                ->count_all();
        } else {
            $count = ORM::factory('News')
                ->where('status', '=', 'published')
                ->and_where('competition', '!=', 1)
                ->and_where('dontshow', '=', 0)
                ->and_where('language_id', '=', $this->language->id)
                ->count_all();
        }

        $pagination = Pagination::factory(array(
            'total_items' => $count,
            'items_per_page' => $this->config->news_count,
        ));

        if ($slug) {
            $news = $category->news
                ->where('competition', '!=', 1)
                ->and_where('status', '=', 'published')
                ->and_where('dontshow', '=', 0)
                ->and_where('language_id', '=', $this->language->id)
                ->order_by('new', 'DESC')
                ->order_by('created', 'DESC')
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ->find_all();
        } else {
            $news = ORM::factory('News')
                ->where('competition', '!=', 1)
                ->and_where('status', '=', 'published')
                ->and_where('dontshow', '=', 0)
                ->and_where('language_id', '=', $this->language->id)
                ->order_by('new', 'DESC')
                ->order_by('created', 'DESC')
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ->find_all();
        }

        $content->news = $news;
        $content->page_links = $pagination->render();

        if (isset($category)) {
            if ($category->rss_link) {
                $feed = Remote::get($category->rss_link);
                $content = Feed::parse($feed);
                $this->template->content = View::factory('news/rss');
                $this->template->content->news = $content;
            }
            $this->category = $category;
        }

        $title = ORM::factory('Page')->module_title('news', $this->language->id);
        $this->breadcrumbs['news'] = $title;
        if ($slug) {
            $this->breadcrumbs['news/category/' . $category->slug] = $category->title;
        }
        $this->template->title = $title;
    }

    public function action_view($slug) {
        $content = $this->template->content = View::factory('news/view');
        $article = ORM::factory('News')->where('slug', '=', $slug)->find();
        $content->article = $article;

        if ($_POST) {
            $comment = ORM::factory('Comment');
            $_POST['created'] = DB::expr('NOW()');
            $_POST['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $comment->values($_POST);
            if ($comment->check()) {
                $comment->save();
            } else {
                $content->errors = $comment->validate()->errors('validate');
            }
        }
        if ($article->comments_enabled) {
            $content->comments = ORM::factory('Comment')
                ->where('module', '=', 'news')
                ->and_where('module_id', '=', $article->id)
                ->and_where('active', '=', '1')
                ->order_by('created', 'DESC')
                ->find_all();
        }

        $category = ORM::factory('Category')->find($article->category_id);
        $content->category = $category;
        $content->print = $this->print;

        $content->photos = ORM::factory('Media')->get_media('news', $article->id, 'photo');
        $content->documents = ORM::factory('Media')->get_media('news', $article->id, 'document');

        $title = ORM::factory('Page')->module_title('news', $this->language->id);
        $this->breadcrumbs['news'] = $title;
        if ($category->show) {
            $this->breadcrumbs['news/category/' . $category->slug] = $category->title;
        }
        $this->breadcrumbs['news/' . $article->slug] = $article->title;
        $this->template->title = $article->title;
    }

}