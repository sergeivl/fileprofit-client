<?php namespace App\Console;

use App\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoriesSaveService;
use App\Services\GamesSaveService;

class CategoriesDataController extends Controller
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

    public function saveToJsonConfig()
    {
        $categories = Category::all();

        $categoryAliases = [];
        foreach ($categories as $category) {
            $categoryAliases[]  = $category->alias;
        }

        file_put_contents('../config/categories.json', \GuzzleHttp\json_encode($categoryAliases));
    }

}