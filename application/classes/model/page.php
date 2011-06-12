<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Page extends ORM {

    // Relationships
    protected $_has_many = array(
        'contents' => array('model' => 'content'),
        'titles' => array('model' => 'title'),
    );
    protected $_belongs_to = array('layouts' => array('model' => 'layout'));

    // Validation rules
    protected $_rules = array();

    public function get_module_page($module, $language = 1) {
        $page = ORM::factory('Page')
            ->where('module','=',$module)
            ->find();
        $title = $page->titles->where('language_id','=',$language)->find();
        if ( ! $title->loaded()) {
            $language = ORM::factory('Language')->get_default();
            $title = $page->titles->where('language_id','=',$language->id)->find();
        }
        return $this->get_page($title->slug);
    }

    public function get_page_data($id) {
        $data = array();
        $page = $this->find($id);
        $language = ORM::factory('Language')->get_default();

        $title = $page->titles->where('language_id','=',$language->id)->find();
        if ( ! $title->loaded()) {
            $title = $page->titles->find();
            $language = ORM::factory('Language')->find($title->language_id);
        }
        $content = $page->contents->where('language_id','=',$language->id)->find();

        $data['language'] = $language;
        $data['title'] = $title;
        $data['content'] = $content;
        return $data;
    }

    public function get_page_list($language_id = 1) {
        $pages = array(0 => '-- '.__('Select page').' --');
        foreach ($this->get_child_pages(0, $language_id) AS $page) {
            $pages[$page->id] = '-- '.$page->title;
            if ($page->childs) {
                foreach ($this->get_child_pages($page->id, $language_id) AS $page1) {
                    $pages[$page1->id] = '&nbsp; &nbsp; -- '.$page1->title;
                    if ($page1->childs) {
                        foreach ($this->get_child_pages($page1->id, $language_id) AS $page2) {
                            $pages[$page2->id] = '&nbsp; &nbsp; &nbsp; &nbsp; -- '.$page2->title;
                            if ($page2->childs) {
                                foreach ($this->get_child_pages($page2->id, $language_id) AS $page3) {
                                    $pages[$page3->id] = '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -- '.$page3->title;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $pages;
    }

    public function get_child_pages($parent_id = 0, $language_id = 1) {
        $query = DB::select('pages.*', 'subpages.childs', 'titles.language_id', 'titles.slug', 'titles.title')
            ->from('titles', 'pages')
            ->join(DB::expr('(SELECT TRUE AS childs, parent_id FROM pages GROUP BY parent_id) subpages'), 'LEFT')
            ->on('pages.id', '=', 'subpages.parent_id')
            ->where('pages.parent_id', '=', $parent_id)
            ->and_where('pages.id', '=', DB::expr('titles.page_id'))
            ->and_where('pages.status', '!=', 'deleted')
            ->and_where('titles.language_id', '=', $language_id)
            ->order_by('pages.position', 'ASC')
            ->as_object('Model_Page')
            ->execute();
        return $query;
    }

    public function get_new_position($parent_id = 0) {
        $page = DB::select(array(DB::expr('MAX(position)'),'max_position'))
            ->from('pages')
            ->where('parent_id','=',$parent_id)
            ->execute();
        return ((int) $page->get('max_position', 0) + 1);
    }

    public function get_page_link($id, $language) {
        $slug = array();
        $exit = FALSE;
        while ( ! $exit) {
            $page = $this->find($id);
            $id = $page->parent_id;
            $title = $page->titles->where('language_id','=',$language->id)->find();
            if ($title->loaded()) {
                $slug[] = $title->slug;
            }
            if ($page->parent_id == 0) {
                $exit = TRUE;
            }
        }
        return implode('/', array_reverse($slug));
    }

    public function display_children($parent, $level, $language, $link = '') {
        $pages = $this->get_navigation($language->id, $parent);
        echo '<ul class="level'.$level.'">';
        foreach ($pages AS $page) {
            echo '<li>';
            if ($page->url) {
                echo HTML::anchor($page->url, $page->title, array('class' => 'level'.$level, 'target' => $page->url_target));
            } else {
                echo HTML::anchor($language->locale.'/'.$link.$page->slug.'/', $page->title, array('class' => 'level'.$level));
            }
            if ($page->childs) {
                $this->display_children($page->page_id, $level + 1, $language, $link.$page->slug.'/');
            }
            echo '</li>';
        }
        echo '</ul>';
    }
    
    public function module_title($module, $language) {
        $page = $this->where('module','=',$module)->find();
        $title = $page->titles->where('language_id','=',$language)->find();
        return $title->title;
    }

    public function link($id, $language_id = NULL) {
        $page = $this->select('pages.*','titles.slug','titles.title')
            ->join('titles', 'LEFT')
            ->on('pages.id','=','titles.page_id')
            ->where('pages.id','=',$id)
            ->and_where('titles.language_id','=',$language_id)
            ->find();
        return ($page->loaded()) ? $page : NULL;
    }

    // CACHABLE
    public function get_page($slug, $long = FALSE) {
        $condition = (($long) ? 't.long_slug' : 't.slug')." = '{$slug}'";
        $sql = "SELECT p.*, t.*, c.* "
            ."FROM pages p LEFT JOIN titles t ON p.id = t.page_id "
            ."LEFT JOIN contents c ON p.id = c.page_id AND t.language_id = c.language_id "
            ."WHERE {$condition}";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute()
            ->current();
        return $result;
    }

    public function get_navigation($language, $parent = 0) {
        $sql = "SELECT p.*, t.*, sp.childs "
            ."FROM pages p LEFT JOIN titles t ON p.id = t.page_id "
            ."LEFT JOIN (SELECT TRUE AS childs, parent_id FROM pages WHERE status = 'published' GROUP BY parent_id) sp ON p.id = sp.parent_id "
            ."WHERE p.parent_id = '{$parent}' AND p.status = 'published' AND t.language_id = {$language} "
            ."ORDER BY p.position";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute()
            ->as_array();
        return $result;
    }

}
