<?php defined('SYSPATH') or die('No direct script access.');

class Num extends Kohana_Num {

    public static function currency($name = FALSE) {
        $currency = Session::instance()->get('currency');
		if ($name) {
			return $currency;
		}
        return Kohana::config('application')->currency[$currency];
    }
	
	

}
