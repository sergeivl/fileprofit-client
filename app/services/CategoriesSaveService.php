<?php namespace App\Services;


use App\Models\Category;
use GuzzleHttp\Client;

class CategoriesSaveService extends Service
{

    /**
    * Выгрузка и сохранение категорий с API
     * */
    public function saveAllCategories()
    {
        $client = new Client();
        $res = $client->request('GET', $this->container->settings['api'] . '/api/get-categories');

        $categories = [];

        if ($res->getStatusCode() === 200) {
            $categories = \GuzzleHttp\json_decode($res->getBody(), true);
        }
        foreach ($categories as $category) {
            $model = Category::where('id', $category['id'])->first();
            if (empty($model)) {
                $model = new Category;
                $model->id = $category['id'];
                $model->title = $category['name'];
                $model->alias = $category['alias'];
                $model->save();
                $this->container['logger']->addInfo('Категория сохранена');
            } else {
                $this->container['logger']->addInfo('Категория уже существует');
            }
        }
    }

    public function updateAllCategories()
    {
        $client = new Client();
        $res = $client->request('GET', $this->container->settings['api'] . '/api/get-categories');

        $categories = [];

        if ($res->getStatusCode() === 200) {
            $categories = \GuzzleHttp\json_decode($res->getBody(), true);
        }
        foreach ($categories as $category) {
            $model = Category::where('id', $category['id'])->first();
            if (empty($model)) {
                $model = new Category;
            }

            $model->id = $category['id'];
            $model->title = $category['name'];

            $model->title_seo = $category['name'];
            $model->alias = $category['alias'];
            $model->save();
            $this->container['logger']->addInfo('Категория обновлена');
        }
    }
}