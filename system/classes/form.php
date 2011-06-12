<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {

	public static function label($input, $text = NULL, array $attributes = NULL, $required = FALSE) {
		if ($required) {
			$text .= ' <span class="required">*</span>';
		}
		return parent::label($input, $text, $attributes);
	}
	
	public static function input($name, $value = NULL, array $attributes = NULL) {
		if ( ! isset($attributes['id'])) {
			$attributes['id'] = $name;
		}
		return parent::input($name, $value, $attributes);
	}
	
	public static function select($name, array $options = NULL, $selected = NULL, array $attributes = NULL) {
		if ( ! isset($attributes['id'])) {
			$attributes['id'] = preg_replace("/\[\]/i","",$name);
		}
                if (count($options) == 0) {
                    $options[0] = '--';
                }
		return parent::select($name, $options, $selected, $attributes);
	}

        public static function textarea($name, $body = '', array $attributes = NULL, $double_encode = TRUE) {
		if ( ! isset($attributes['id'])) {
			$attributes['id'] = $name;
		}
		return parent::textarea($name, $body, $attributes, $double_encode);
	}
	
	public static function button($name, $body, array $attributes = NULL) {
		if ( ! isset($attributes['type'])) {
			$attributes['type'] = 'button';
		}
		return self::input($name, $body, $attributes);
	}
	
}
