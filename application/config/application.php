<?php

defined('SYSPATH') or die('No direct script access.');

return array(
    // Uploads
    'image_extensions' => array('jpeg', 'jpg', 'gif', 'png', 'bmp', 'JPEG', 'JPG', 'GIF', 'PNG', 'BMP'),
    'document_extension' => array('txt', 'doc', 'docx', 'rtf', 'pdf', 'odt', 'xls', 'xlsx', 'ods', 'TXT', 'DOC', 'DOCX', 'RTF', 'PDF', 'ODT', 'XLS', 'XLSX', 'ODS'),
    'size_limit' => 10 * 1024 * 1024,
    
    // Paths
    'upload_dir' => 'uploads/',
    'tmp_upload_dir' => 'uploads/.tmp/',
    
    // Tim thumbs
    'thumb_url' => 'vendor/thumb.php?src=',
    'thumb_size' => array(
        'width' => 143,
        'height' => 95,
    ),
    
    // Modules
    'modules' => array(
        '' => __('Select module'),
        'news' => __('News'),
        'feedback' => __('Feedback'),
        'references' => __('References'),
        'new_reference' => __('New reference'),
        'gallery' => __('Gallery'),
        'files' => __('Files'),
    ),
    'simple_modules' => array(
        'feedback', 'references', 'new_reference', 'gallery', 'news', 'files',
    ),
    
    // Blocks
    'plugins' => array(
        '' => __('Select plugin'),
        'banners' => __('Banners'),
        'latest_news_small' => __('Latest news small'),
        'latest_news_big' => __('Latest news big'),
        'footer' => __('Footer'),
    ),
    'block_types' => array(
        'main_left' => __('Mainpage left'),
        'main_top' => __('Mainpage top'),
        'main_center' => __('Mainpage center'),
        'main_bottom' => __('Mainpage bottom'),
        'main_right' => __('Mainpage right'),
        'page_left' => __('Page left'),
        'page_right' => __('Page right'),
        'footer' => __('Footer'),
    ),
    
    // Languages
    'language' => array(
        'id' => 1,
        'locale' => 'en',
    ),
    
    // Contacts
    'email' => 'info@balthost.eu',
    'error_message' => 'info@digitalmedia.lv',
    
    // Cache
    'cache' => TRUE,
    'cache_instance' => 'file',
    
    // META information
    'meta_title' => 'meta title',
    'meta_description' => 'meta description',
    'meta_keywords' => 'meta keywords',
);