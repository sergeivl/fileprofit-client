<?php namespace App\Console;

use App\Controllers\Controller;
use App\Services\CategoriesSaveService;
use App\Services\GamesDeleteService;
use App\Services\GamesSaveService;


class GamesDataController extends Controller
{
    public function getCategories()
    {
        $service = new CategoriesSaveService($this->container);
        $service->saveAllCategories();
    }

    public function updateCategories()
    {
        $service = new CategoriesSaveService($this->container);
        $service->updateAllCategories();
    }

    public function getGames()
    {
        $service = new GamesSaveService($this->container);
        $service->saveAllGames();
    }

    public function updateGames($fields = [])
    {
        $service = new GamesSaveService($this->container);
        $service->updateAllGames($fields);
    }

    public function deleteGames()
    {
        $service = new GamesDeleteService($this->container);
        $service->deleteAll();
    }

}