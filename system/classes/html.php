<?php

defined('SYSPATH') or die('No direct script access.');

class HTML extends Kohana_HTML {
    const ALERT = 'alert';
    const WARNING = 'warning';
    const ACCEPT = 'accept';

    public static function flash_message($errors, $type = HTML::ALERT) {
        $content = '';
        if (is_array($errors) AND isset($errors['type'])) {
            $type = $errors['type'];
            $errors = $errors['messages'];
        }
        if (is_array($errors)) {
            foreach ($errors AS $error) {
                $error = str_replace('password must be at least 5 characters long', 'Parolei jāsatur vismaz 5 simboli', $error);
                $error = str_replace('email address must not be empty', 'Jāievada e-pasta adrese', $error);
                $error = str_replace('username must not be empty', 'Jāievada lietotāja vārds', $error);
                $error = str_replace('password confirmation must be the same as password', 'Paroles apstiprinājumam jāsakrīt ar paroli', $error);
                $error = str_replace('name must not be empty', 'Jāievada nosaukums', $error);
                $error = str_replace('name must be at least 4 characters long', 'Nosaukumam jāsatur vismaz 4 simboli', $error);
                $error = str_replace('title must not be empty', 'Jāievada virsraksts', $error);
                $error = str_replace('body must not be empty', 'Jāievada saturs', $error);
                $error = str_replace('question must not be empty', 'Jāievada jautājums', $error);
                $error = str_replace('start_date must not be empty', 'Jāievada sākuma datums', $error);
                $error = str_replace('slug must not be empty', '', $error);

                $content .= '<li>' . $error . '</li>';
            }
        }
        if (is_string($errors)) {
            $content .= '<li>' . $errors . '</li>';
        }
        return '<ul class="' . $type . '">' . $content . '</ul>';
    }

    public static function anchor_array(array $anchors) {
        $count = count($anchors);
        $data = "";
        $i = 0;
        foreach ($anchors AS $link => $title) {
            $i++;
            if ($count == $i) {
                $data .= '<li class="active">'.$title.'</li>';
            } else {
                $data .= '<li>'.HTML::anchor($link, $title).'</li>';
            }
        }
        return $data;
    }

    public static function nav($uri, $title, $active = FALSE, $attributes = array()) {
        if ($active) {
            if (isset($attributes['class'])) {
                $attributes['class'] = $attributes['class'] . 'active';
            } else {
                $attributes['class'] = 'active';
            }
        }
        return parent::anchor($uri, $title, $attributes);
    }

    public static function sidebar_menu($link, $title, $active = FALSE, $attributes = array()) {
        return '<li>' . self::nav($link, $title, $active, $attributes) . '</li>';
    }

    public static function currency() {
        $currencies = Kohana::config('application')->currency;
        $currency = Session::instance()->get('currency');
        if (!$currency) {
            $currency = Kohana::config('application')->geo['default']['currency'];
            Session::instance()->set('currency', $currency);
        }
        $currency_list = array();
        foreach ($currencies AS $k => $v) {
            $currency_list[$k] = $k;
        }
        return Form::select('currency', $currency_list, $currency);
    }

    public static function link($id, $title = NULL, $attributes = NULL, $language_id = NULL) {
        if (!$language_id) {
            $language = Session::instance()->get('language');
            if (!isset($language->id)) {
                $language = ORM::factory('Language')->get_default();
            }
            $language_id = isset($language->id) ? $language->id : 0;
        }
        $page = ORM::factory('Page')->link($id, $language_id);
        if (!isset($page->slug)) {
            return "";
        }
        if (!$title) {
            $title = $page->title;
        }
        if ($attributes) {
            $attributes = explode('#', $attributes);
            if (is_array($attributes) AND count($attributes) > 0) {
                $attr_array = array();
                foreach ($attributes AS $attribute) {
                    $attr = explode('=', $attribute);
                    if (is_array($attr) AND count($attr) == 2) {
                        $attr_array[$attr[0]] = str_replace('"', '', $attr[1]);
                    }
                }
                $attributes = $attr_array;
            }
        }
        return self::anchor($page->slug, $title, $attributes);
    }

    public static function image_thumb($image, $width = NULL, $height = NULL, $crop = TRUE, $attributes = array()) {
        $thumber = Kohana::config('application')->thumb_url;
        $file = $thumber . '/' . $image;
        if ($width) {
            $file .= '&w=' . $width;
        }
        if ($height) {
            $file .= '&h=' . $height;
        }
        if ($crop) {
            $file .= '&zc=1';
        }
        return self::image($file, $attributes);
    }

}
