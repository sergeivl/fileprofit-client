<?php namespace App\Services;

use App\Models\Category;
use App\Models\Game;

class GeneratorYandexTurboService extends Service
{
    private $baseUrl;

    public function generate()
    {
        $this->baseUrl = $this->container->settings['baseUrl'];

        $channelData = $this->getChannelData();
        $itemsData = $this->getItemsData();

        //print_r($itemsData);
        //die();

        $service = new YandexTurboService($this->container, $channelData, $itemsData);
        $service->generate();

    }

    private function getChannelData()
    {
        $channelData = [
            'title' => 'Скачать игры бесплатно',
            'link' => 'http://tut-games.ru',
            'description' => 'У нас можно скачать бесплатные игры на пк через торрент на русском',
            'language' => 'ru',
            'pubDate' => time()
        ];

        return $channelData;
    }

    private function getItemsData()
    {
        $itemsData = [];

        /** @var Game[] $games */
        $games = Game::where('status', 1)->where('date_public', '<', date('Y-m-d H:i:s'))->get();
        $categories = Category::getCategoryList();
        foreach ($games as $game) {
            $itemsData[] = $this->makeGameItem($game, $categories);
        }

        return $itemsData;
    }

    private function makeGameItem(Game $game, $categories)
    {
        $relatedItems = $this->getRelatedGames($game);
        $cover = '<figure><img src="' . $this->baseUrl . $game->cover . '" alt="' . $game->title . '"></figure>';

        $buttonLink = $this->baseUrl  . $game->getGameLink();
        $imgLink =  $this->baseUrl . '/themes/standart/img/download-button-green.png';

        //$downloadButton = '<a href="'. $buttonLink. '"><img src="' . $imgLink . '"></a>';
        //var_dump($downloadButton);
        //$downloadButton = '<a href="'.$this->baseUrl . '/' . $game->title.'" style="width: 100%; border-radius: 6px; padding: 10px 16px; font-size: 18px; line-height: 1.3333333; margin-top: 20px; display: inline-block;"'

        $turboContent = $cover . $game->content;

        return [
            'title' => $game->title,
            'link' => $this->baseUrl . $game->getGameLink(),
            'category' => $categories[$game->getMainCategoryId()],
            'turboContent' => $turboContent,
            'pubDate' => time(),
            'related' => $relatedItems
        ];
    }

    private function getRelatedGames($game)
    {
        /** @var Game[] $moreGames */
        $moreGames = Game::whereHas('taxonomy', function ($query) use ($game) {
            /** @var Game $game */
            $query->where('category_id', '=', $game->getMainCategoryId());
        })
            ->where('status', 1)
            ->where('date_release', '<', $game->date_release)
            ->where('date_public', '<', date('Y-m-d H:i:s'))
            ->orderBy('date_release', 'desc')
            ->get();

        $relatedItems = [];

        foreach ($moreGames as $moreGame) {
            $relatedItems[] = [
                'title' => $moreGame->title,
                'link' => $this->baseUrl . $moreGame->getGameLink(),
                'img' => $this->baseUrl . $moreGame->cover
            ];
        }

        return $relatedItems;
    }
}
