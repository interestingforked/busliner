<?php

defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------
date_default_timezone_set('Europe/Riga');
setlocale(LC_ALL, 'en_US.utf-8');
spl_autoload_register(array('Kohana', 'auto_load'));
ini_set('unserialize_callback_func', 'spl_autoload_call');

define('DS', '/');

//-- Configuration and initialization -----------------------------------------
Kohana::init(array(
            'base_url' => '/',
            'index_file' => '',
            'errors' => TRUE,
            'profile' => TRUE,
            'caching' => TRUE,
        ));

Kohana::$log->attach(new Kohana_Log_File(APPPATH . 'logs'));
Kohana::$config->attach(new Kohana_Config_File);
Kohana::modules(array(
            'auth' => MODPATH . 'auth', // Basic authentication
            //'captcha' => MODPATH.'captcha',      // Captcha
            'database' => MODPATH . 'database', // Database access
            'orm' => MODPATH . 'orm', // Object Relationship Mapping
            'pagination' => MODPATH . 'pagination', // Paging of results
            'uploader' => MODPATH . 'uploader', // File uploader
            //'calendar' => MODPATH.'calendar',  // Calendar
            'cart' => MODPATH . 'cart', // Cart
            'whois' => MODPATH . 'whois', // Whois
            'cache' => MODPATH . 'cache', // Cache
        ));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('login', 'admin(/<action>(/<id>))',
                array('action' => 'login|force|logout|noaccess'))
        ->defaults(array(
            'directory' => 'admin',
            'controller' => 'application',
            'action' => 'login',
        ));

Route::set('upload', 'admin/ajax/upload/?qqfile=<param>',
                array('param' => '.*'))
        ->defaults(array(
            'directory' => 'admin',
            'controller' => 'ajax',
            'action' => 'upload',
        ));

Route::set('admin', 'admin(/<controller>(/<action>(/<id>(/<param>))))')
        ->defaults(array(
            'directory' => 'admin',
            'controller' => 'dashboard',
            'action' => 'index',
        ));

Route::set('language', '<language>',
                array('language' => '[a-zA-Z]{2}'))
        ->defaults(array(
            'controller' => 'application',
            'action' => 'index',
        ));

Route::set('ajax', '<action>(/<param>)',
                array('action' => 'send|rss|download', 'param' => '.*'))
        ->defaults(array(
            'controller' => 'ajax',
            'action' => 'send',
        ));

Route::set('error', 'error(/<action>(/<id>))',
                array('action' => '404|500', 'id' => '.+'))
        ->defaults(array(
            'controller' => 'error',
            'action' => '404',
        ));

Route::set('default', '(<controller>(/<action>(/<id>)))',
                array('controller' => 'news|sitemap|search|modules', 'id' => '.*'))
        ->defaults(array(
            'controller' => 'application',
            'action' => 'index',
        ));

Route::set('pages', '(<language>/)<page>',
                array('language' => '[a-zA-Z]{2}', 'page' => '[a-zA-Z0-9\-\/\?]+'))
        ->defaults(array(
            'controller' => 'pages',
            'action' => 'index',
        ));

Route::set('other', '<id>',
                array('id' => '.*'))
        ->defaults(array(
            'controller' => 'application',
            'action' => 'index',
        ));

if (!defined('SUPPRESS_REQUEST')) {
    $request = Request::instance();
    try {
        $request->execute();
    } catch (Request_Exception $e) {
        $error_page = Route::get('error')->uri(array('action' => '404', 'id' => $request->uri()));
        $error_request = Request::factory($error_page);
        $error_request->execute();
        $error_request->status = 404;
        if ($error_request->send_headers()) {
            die($error_request->response);
        }
    } catch (Exception $e) {
        $error = Kohana::exception_text($e);
        Kohana::$log->add(Kohana::ERROR, $error);
        Kohana::$log->write();

        $error_page = Route::get('error')->uri(array('action' => '500', 'id' => $request->uri()));
        $error_request = Request::factory($error_page);
        $error_request->exception = $error;
        $error_request->execute();
        $error_request->status = 500;

        $config = Kohana::config('application');

        $mail = $config->error_message;
        $subject = 'Kohana error from '.$_SERVER['SERVER_NAME'];
        $headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Kohana exception handler <errors@'.$_SERVER['SERVER_NAME'].'>' . "\r\n";
        $headers .= 'Bcc: pavel@csscat.com' . "\r\n";

        mail($mail, $subject, $e, $headers);

        if ($error_request->send_headers()) {
            die($error_request->response);
        }
    }
    if ($request->send_headers()->response) {
        echo $request->response;
    }
}