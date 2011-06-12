<?php defined('SYSPATH') or die('No direct script access.');

class Request_Exception extends Kohana_Request_Exception {

    public function __construct($message, array $variables = NULL, $code = 0) {
        // Set the message
        $message = __($message, $variables);
        
        // Pass the message to the parent
        parent::__construct($message, $variables, $code);
    }

}
