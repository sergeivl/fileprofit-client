<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'templatesPath' => '../templates',
        'theme' => 'tut-games',
        'db' => require 'db.php',
        'categories' => json_decode(file_get_contents('categories.json', true), true),
        'pagination' => require 'pagination.php',
        'api' => 'http://fileprofit.local',
        'games_content_type' => 'TutGames'
    ],
];