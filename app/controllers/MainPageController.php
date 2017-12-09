<?php namespace App\Controllers;

use App\Models\Game;
use App\Models\Page;
use App\Services\PaginatorService;
use Slim\Views\PhpRenderer;

class MainPageController extends Controller
{
    public function show($request, $response, $args)
    {
        $page = Page::where('alias', 'main')->first();
        $pageNumber = isset($args['pageNumber']) ? (int)$args['pageNumber'] : 1;

        $pageData['title_seo'] = $page->title_seo ? $page->title_seo : $page->title;
        $pageData['title'] = $page->title;
        $pageData['alias'] = $page->alias;

        $limit = 9;
        if ($pageNumber > 1) {
            $offset = ($pageNumber-1)*$limit;
            $games = Game::orderBy('date_release', 'desc')->skip($offset)->take(9)->get();
        } else {
            $games = Game::orderBy('date_release', 'desc')->take(9)->get();
        }

        $totalGames = Game::all()->count();

        /** @var PhpRenderer $view */
        $view = $this->container->view;

        $paginator = new PaginatorService($this->container);

        $paginator->setCurrentPage($pageNumber);
        $paginator->setItemsPerPage($this->container->get('settings')['pagination']['itemsPerPage']);
        $paginator->setMaxPaginationElements($this->container->get('settings')['pagination']['maxPaginationElements']);
        $paginator->setTotalPages(ceil(($totalGames/$this->container->get('settings')['pagination']['itemsPerPage'])));

        return $view->render($response, 'layout.php', [
            'subtemplate' => 'mainpage',
            'pageData' => $page,
            'games' => $games,
            'paginator' => $paginator
        ]);
    }
}