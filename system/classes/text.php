<?php

defined('SYSPATH') or die('No direct script access.');

class Text extends Kohana_Text {

    private static $niddle = array(
        "/а/", "/б/", "/в/", "/г/", "/д/", "/е/", "/ё/", "/ж/", "/з/", "/и/", "/й/", "/к/", "/л/", "/м/", "/н/", "/о/",
        "/п/", "/р/", "/с/", "/т/", "/у/", "/ф/", "/х/", "/ц/", "/ч/", "/ш/", "/щ/", "/ъ/", "/ы/", "/ь/", "/э/", "/ю/", "/я/",
        "/А/", "/Б/", "/В/", "/Г/", "/Д/", "/Е/", "/Ё/", "/Ж/", "/З/", "/И/", "/Й/", "/К/", "/Л/", "/М/", "/Н/", "/О/",
        "/П/", "/Р/", "/С/", "/Т/", "/У/", "/Ф/", "/Х/", "/Ц/", "/Ч/", "/Ш/", "/Щ/", "/Ъ/", "/Ы/", "/Ь/", "/Э/", "/Ю/", "/Я/");

    private static $replace = array (
        "a", "b", "v", "g", "d", "e", "yo", "zh", "z", "i", "j", "k", "l", "m", "n", "o",
        "p", "r", "s", "t", "u", "f", "h", "c", "ch", "sh", "sch", "", "y", "", "e", "yu", "ya",
        "A", "B", "V", "G", "D", "E", "YO", "ZH", "Z", "I", "J", "K", "L", "M", "N", "O",
        "P", "R", "S", "T", "U", "F", "H", "C", "CH", "SH", "SCH", "", "Y", "", "E", "YU", "YA"
    );

    public static function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = Text::translitirate($text);
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return '';
        }
        return $text;
    }

    public static function split_fullname($fullname) {
        list($first, $last) = explode(' ', $fullname);
        return array(
            'firstname' => $first,
            'lastname' => $last,
        );
    }

    public static function translitirate($string) {
        return preg_replace(Text::$niddle, Text::$replace, $string);
    }

    public static function get_intro($content, $limit = 30) {
        $content = preg_replace("/<img[^>]+\>/i", "", $content);
        $content = preg_replace("/style=\"[^\"]*\"|'[^']*'/i", "", $content);
        $found = preg_match("/<p[^\/]+\/p>/i", $content, $matches);
        if ($found AND strlen($matches[0]) > 50) {
            return $matches[0];
        }
        return parent::limit_words(strip_tags($content), $limit);
    }

    public static function get_image($content) {
		$first200 = substr($content,0,200);
        $found = preg_match('/(http:\/\/|\/uploads\/).*(jpg|jpeg|gif|png)/i', $first200, $matches);
        if ($found) {
            return $matches[0];
        }
        return FALSE;
    }

    public static function strip_image($content, $width, $height) {
        //$content = preg_replace('/<img .* width="[0-9]+" .*\/>/', 'width="'.$width.'"', $content);
        //$content = preg_replace('/<img .* height="[0-9]+" .*\/>/', 'width="'.$height.'"', $content);
        $content = preg_replace('/<img.*?\/?>/', '', $content, 1);
        return $content;
    }

    public static function text_version($content) {
        preg_match_all("/<img[^>]+\>/i", $content, $matches);
        foreach ($matches[0] AS $image) {
            if (preg_match('/(width|height)/', $image)) {
                $replaced_image = preg_replace('/src=("[^"]*")/i', '', $image);
            } else {
                $replaced_image = '';
            }
            $content = str_ireplace($image, $replaced_image, $content);
        }
        return $content;
    }

    public static function hl($text, $pattern) {
        return preg_replace($pattern, '<b class="hl">'.$pattern.'</b>', $text);
    }

}
