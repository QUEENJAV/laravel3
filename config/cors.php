<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // 'allowed_methods' => ['GET', 'POST', 'PUT', 'DELET', 'OPTIONS'],

    'allowed_origins' => ['http://localhost:3000'],

    'allowed_origins_patterns' => [],
    'allowedHeaders'=> ['Content-Type', 'Authorization'],  

    'allowed_headers' => ['http://localhost:3000'],
    'allowed_headers' => [
        'Content-Type', 
        'X-Requested-With', 
        'Authorization', 
        'X-CSRF-Token', 
        'Accept'
    ],
    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
