<?php defined('SYSPATH') or die('No direct script access.');

class Arr extends Kohana_Arr {

    public static function obj_to_str($object, $keys) {
        $found = array();
        foreach ($object AS $item) {
            foreach ($keys AS $key) {
                $found[] = (isset($item->$key)) ? $item->$key : NULL;
            }
        }
        return implode(', ', $found);
    }

}