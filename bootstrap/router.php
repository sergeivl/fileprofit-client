<?php

use App\Middleware\AuthMiddleware;

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



// Поиск
$app->get('/search/{query}',  'GameController:search');

// Админка
$app->get('/admin/login',  'AdminController:login');
$app->post('/admin/login',  'AdminController:login');
$app->group('', function () use ($categoryAliases) {
    $this->get('/admin[/]',  'AdminController:gameList');
    $this->get('/admin/{pageNumber:[0-9]+}',  'AdminController:gameList');
    $this->get('/admin/{category:' . implode('|', $categoryAliases) . '}',  'AdminController:gameList');
    $this->get(
        '/admin/{category:' . implode('|', $categoryAliases) . '}/{pageNumber:[0-9]+}',
        'AdminController:gameList'
    );

    $this->get('/admin/game/{id:[0-9]+}',  'AdminController:gameEdit');
    $this->post('/admin/game/{id:[0-9]+}',  'AdminController:gameEdit');
    $this->get('/admin/game/delete/{id:[0-9]+}',  'AdminController:gameDelete');
    $this->get('/admin/game/change-status/{id:[0-9]+}',  'AdminController:gameChangeStatus');

    $this->get('/admin/pages',  'AdminController:pagesList');
    $this->get('/admin/pages/edit/{id:[0-9]+}',  'AdminController:pagesEdit');
    $this->post('/admin/pages/edit/{id:[0-9]+}',  'AdminController:pagesEdit');

    $this->get('/admin/categories',  'AdminController:categoriesList');
    $this->get('/admin/categories/edit/{id:[0-9]+}',  'AdminController:categoriesEdit');
    $this->post('/admin/categories/edit/{id:[0-9]+}',  'AdminController:categoriesEdit');

    $this->get('/admin/menu',  'AdminController:menuEdit');
    $this->post('/admin/menu',  'AdminController:menuEdit');
    $this->post('/admin/save-menu-sorting',  'AdminController:saveMenuSorting');
    $this->post('/admin/menu-add-categories',  'AdminController:menuAddCategories');
    $this->post('/admin/edit-item-menu',  'AdminController:editItemMenu');
    $this->post('/admin/delete-item-menu',  'AdminController:deleteItemMenu');
})->add(new AuthMiddleware($container));

