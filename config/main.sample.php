<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'templatesPath' => '../templates',
        'theme' => 'standart',
        'db' => require 'db.php',
        'categories' => json_decode(file_get_contents('categories.json', true), true),
        'pagination' => require 'pagination.php',
        'api' => 'https://fileprofit.net',
        'games_content_type' => 'TutGames'
    ],
];