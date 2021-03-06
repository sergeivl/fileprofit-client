<?php namespace App\Services;

use App\Models\Game;

class GamesDeleteService extends Service
{
    /*
 * Выгрузка и сохранение категорий с API
 * */
    public function deleteAll()
    {
        $this->container['logger']->addInfo('Очищаем таблицу игр');
        $db = $this->container['db'];
        $db::statement("SET foreign_key_checks=0");
        Game::truncate();
        $db::statement("SET foreign_key_checks=1");
        $this->container['logger']->addInfo('Таблица с играми очищена');
    }

}