<?php

if (php_sapi_name() === 'cli') {
    switch ($argv[1]) {
        case 'GamesDataController/getCategories':
            $container['GamesDataController']->getCategories();
            break;
        case 'GamesDataController/updateCategories':
            $container['GamesDataController']->updateCategories();
            break;
        case 'GamesDataController/getGames':
            $container['GamesDataController']->getGames();
            break;
        case 'GamesDataController/updateGames':
            $fields = [];
            if (isset($argv[2])) {
                $fields = explode(',', $argv[2]);
            }
            $container['GamesDataController']->updateGames($fields);
            break;
        case 'GamesDataController/deleteGames':
            //var_dump($container['GamesDataController']);
            $result = $container['GamesDataController']->deleteGames();
            break;
        case 'CategoriesDataController/saveToJsonConfig':
            $container['CategoriesDataController']->saveToJsonConfig();
            break;
        default:
            echo 'Экшен не найден';
    }

    exit;
}


// Главная страница сайта
$app->get('/',  'MainPageController:show');
$app->get('/{pageNumber:[0-9]+}',  'MainPageController:show');

// Простая страница

// Категория игры
$categoryAliases = $container->get('settings')['categories'];

$app->get('/{category:' . implode('|', $categoryAliases) . '}',  'CategoryController:show');
$app->get('/{category:' . implode('|', $categoryAliases) . '}/{pageNumber:[0-9]+}',  'CategoryController:show');

// Игра
$app->get('/{category:' . implode('|', $categoryAliases) .'}/{gameAlias}',  'GameController:show');


// Админка
$app->get('/admin[/]',  'AdminController:gameList');
$app->get('/admin/{pageNumber:[0-9]+}',  'AdminController:gameList');
$app->get('/admin/{category:' . implode('|', $categoryAliases) . '}',  'AdminController:gameList');
$app->get('/admin/{category:' . implode('|', $categoryAliases) . '}/{pageNumber:[0-9]+}',
    'AdminController:gameList');
$app->get('/admin/game/{id:[0-9]+}',  'AdminController:gameEdit');
$app->post('/admin/game/{id:[0-9]+}',  'AdminController:gameEdit');
$app->get('/admin/game/delete/{id:[0-9]+}',  'AdminController:gameDelete');
$app->get('/admin/game/change-status/{id:[0-9]+}',  'AdminController:gameChangeStatus');