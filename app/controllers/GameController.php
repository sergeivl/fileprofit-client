<?php namespace App\Controllers;

use App\Models\Game;
use Slim\Views\PhpRenderer;

class GameController extends Controller
{
    public function show($request, $response, $args)
    {
        /** @var array $args */
        $game = Game::where('alias', $args['gameAlias'])->first();

        $pageData['title_seo'] = $game->title_seo ? $game->title_seo : $game->title;
        $pageData['title'] = $game->title;
        $pageData['alias'] = $args['gameAlias'];

        // $moreGames = [];
        $moreGames = Game::whereHas('taxonomy', function ($query) use ($game) {
            /** @var Game $game */
            $query->where('category_id', '=', $game->getMainCategoryId());
        })
            ->where('date_release', '<', $game->date_release)
            ->orderBy('date_release', 'desc')
            ->take(6)
            ->get();

        /** @var PhpRenderer $view */
        $view = $this->container->view;

        return $view->render($response, 'layout.php', [
            'subtemplate' => 'game',
            'pageData' => $pageData,
            'game' => $game,
            'moreGames' => $moreGames
        ]);
    }

}