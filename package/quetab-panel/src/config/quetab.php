<?php
/**
 * 
 * 
 * This is the default configuration file for Quetab Panel
 * @license GNU
 * @website: https://quetab.com
 * 
 */


return [

    // The route prefix for the admin routes 
    'url_prefix'      =>      'admin/dashboard',
    'prefix'          =>      'admin',

    // Models
    'models' => [
        'user'          =>      [
            'model'     =>      'Quetab\QuetabPanel\Models\User',
            'table'     =>      'users'
        ],
        'page'          =>      [
            'model'     =>      'Quetab\QuetabPanel\Models\Page',
            'table'     =>      'pages'
        ],
        'setting'       =>      [
            'model'     =>      'Quetab\QuetabPanel\Models\Setting',
            'table'     =>      'settings'
        ],
        'support_message' => [
            'model'     =>      'Quetab\QuetabPanel\Models\SupportMessage',
            'table'     =>      'support_messages'
        ],
        'mediaObject'         =>      [
            'model'     =>      'Quetab\QuetabPanel\Models\MediaObject',
            'table'     =>      'media_objects'
        ],
    ],

    'openai' => [
        'key'       => env('OPENAI_API_KEY', ''),
        'base_url'  => env('OPENAI_BASE_URL', 'https://api.openai.com/v1')
    ],

    
];