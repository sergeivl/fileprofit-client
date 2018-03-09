<?php

require __DIR__ . '/../vendor/autoload.php';
$config = require_once  __DIR__ . '/../config/main.php';

$app = new \Slim\App($config);

require_once  __DIR__ . '/dependencies.php';
require_once  __DIR__ . '/middleware.php';
require_once  __DIR__ . '/router.php';

$app->run();