<?php

require '../vendor/autoload.php';
$config = require_once '../config/main.php';

$app = new \Slim\App($config);

require_once 'dependencies.php';
require_once 'middleware.php';
require_once 'router.php';

$app->run();