<?php

defined('SYSPATH') or die('No direct script access.');

class Upload extends Kohana_Upload {

    public static function move_file($tmp_file, $file) {
        if (move_uploaded_file($tmp_file, $file)) {
            // Return new file path
            return $filename;
        }
    }

}
