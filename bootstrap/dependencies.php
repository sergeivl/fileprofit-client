<?php
$container = $app->getContainer();

// Шаблонизатор
$container['view'] = function (\Slim\Container $c) {
    return new \Slim\Views\PhpRenderer($c['settings']['templatesPath'] . '/' . $c['settings']['theme']);
};

// var_dump($config['settings']['db']);

// ORM
$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
    return $capsule;
};


// Контроллеры
$container['MainPageController'] = function (\Slim\Container $c) {
    return new \App\Controllers\MainPageController($c);
};

$container['CategoryController'] = function (\Slim\Container $c) {
    return new \App\Controllers\CategoryController($c);
};

$container['PageController'] = function (\Slim\Container $c) {
    return new \App\Controllers\PageController($c);
};

$container['GameController'] = function (\Slim\Container $c) {
    return new \App\Controllers\GameController($c);
};

$container['AdminController'] = function (\Slim\Container $c) {
    return new \App\Controllers\AdminController($c);
};

$container['auth'] = function (\Slim\Container $c) {
    return new \App\Auth\Auth;
};

// Консольные контроллеры
if (php_sapi_name() === 'cli') {
    $container['GamesDataController'] = function (\Slim\Container $c) {
        return new \App\Console\GamesDataController($c);
    };

    $container['CategoriesDataController'] = function (\Slim\Container $c) {
        return new \App\Console\CategoriesDataController($c);
    };

    $container['logger'] = function($c) {
        $logger = new \Monolog\Logger('cli_logger');
        $handler = new \Monolog\Handler\StreamHandler('php://stdout');
        $logger->pushHandler($handler);
        return $logger;
    };

}
