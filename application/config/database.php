<?php

defined('SYSPATH') or die('No direct access allowed.');

return array(
    'default' => array(
        'type' => 'mysql',
        'connection' => array(
            'hostname' => 'localhost',
            'database' => 'busliner',
            'username' => 'root',
            'password' => '',
            'persistent' => FALSE,
        ),
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => TRUE,
        'profiling' => TRUE,
    ),
);
