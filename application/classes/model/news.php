<?php defined('SYSPATH') or die('No direct script access.');

class Model_News extends ORM {

    // Relationships
    protected $_belongs_to = array(
        'categories' => array('model' => 'category'),
        'languages' => array('model' => 'language'),
    );
    // Validation rules
    protected $_rules = array(
        'title' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(255),
        ),
        'slug' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(255),
        ),
        'body' => array(
            'not_empty' => NULL,
        ),
    );
    protected $_callbacks = array(
        'slug' => array('slug_available'),
    );

    public function slug_available(Validate $array, $field) {
        $exist = (bool) DB::select(array('COUNT("*")', 'total_count'))
            ->from('news')
            ->where('slug', '=', $array[$field])
            ->where($this->_primary_key, '!=', $this->pk())
            ->execute()
            ->get('total_count');
        if ($exist) {
            $array->error($field, 'slug_available', array($array[$field]));
        }
    }

    public function get_last_news($category = FALSE, $limit = 5) {
        $language = Session::instance()->get('language');
        $news = ORM::factory('News')
            ->where('status', '=', 'published')
            ->and_where('dontshow', '=', '0')
            ->and_where('actual', '=', '0')
            ->and_where('competition', '=', '0')
            ->and_where('language_id', '=', $language->id)
            ->order_by('created', 'DESC')
            ->limit($limit)
            ->find_all();
        return $news;
    }

    public function get_by_slug($slug) {
        return $this->where('slug', '=', $slug)->find();
    }
    
    // CACHABLE
    public function get_news_sql($category, $language, $slug = NULL) {
        $condition = ($slug) ? "AND slug = '{$slug}'" : "";
        $sql = "SELECT * "
            ."FROM news "
            ."WHERE `status` = 'published' AND category_id = {$category} AND language_id = {$language} {$condition}";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute();
        return ($slug) ? $result->current() : $result->as_array();
    }

}
