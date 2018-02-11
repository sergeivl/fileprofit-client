<?php namespace App\Console;

use App\Controllers\Controller;
use App\Models\Category;
use App\Models\Game;
use App\Services\YandexTurboService;


class YandexTurboController extends Controller
{
    public function generate()
    {
        $itemsData = [];

        $channelData = [
            'title' => 'Скачать игры бесплатно',
            'link' => 'http://tut-games.ru',
            'description' => 'У нас можно скачать бесплатные игры на пк через торрент на русском',
            'language' => 'ru',
            'pubDate' => time()
        ];

        /** @var Game[] $games */
        $games = Game::where('status', 1)->where('date_public', '<', date('Y-m-d H:i:s'))->get();


        $limit = 5;
        $count = 0;
        $host = 'http://tut-games.ru';

        $categories = Category::getCategoryList();

        foreach ($games as $game) {

            /** @var Game[] $moreGames */
            $moreGames = Game::whereHas('taxonomy', function ($query) use ($game) {
                /** @var Game $game */
                $query->where('category_id', '=', $game->getMainCategoryId());
            })
                ->where('status', 1)
                ->where('date_release', '<', $game->date_release)
                ->where('date_public', '<', date('Y-m-d H:i:s'))
                ->orderBy('date_release', 'desc')
                ->take(6)
                ->get();

            $relatedItems = [];

            foreach ($moreGames as $moreGame) {
                $relatedItems[] = [
                    'title' => $moreGame->title,
                    'link' => $host . $moreGame->getGameLink(),
                    'img' => $host . $moreGame->cover
                ];
            }


            $cover = '<img scr="' . $host . $game->cover . '" alt="' . $game->title . '">';
            $turboContent = $cover . $game->content;
            $itemsData[] = [
                'title' => $game->title,
                'link' => $host . $game->getGameLink(),
                'category' => $categories[$game->getMainCategoryId()],
                'turboContent' => $turboContent,
                'pubDate' => time(),
                'related' => $relatedItems
            ];

            if($count >= $limit) {
                break;
            }
            $count++;
        }

        $service = new YandexTurboService($this->container, $channelData, $itemsData);
        $service->generate();
    }

}