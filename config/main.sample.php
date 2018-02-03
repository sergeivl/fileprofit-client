<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'templatesPath' => '../templates',
        'theme' => 'standart',
        'db' => require 'db.php',
        'auth' => require 'auth.php',
        'categories' => json_decode(file_get_contents('categories.json', true), true),
        'pagination' => require 'pagination.php',
        'api' => 'https://fileprofit.net',
        'token' => 'your_token',
        'games_content_type' => 'Standart',
        'textLogo' => 'Your text logo',
        'watermark' => 'Your watermark'
    ],
];