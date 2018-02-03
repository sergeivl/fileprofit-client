<?php namespace App\Controllers;

use App\Models\Page;
use App\Models\Game;
use App\Services\PaginatorService;
use Slim\Views\PhpRenderer;

class YearController extends Controller
{
    public function show($request, $response, $args)
    {
        $page = Page::where('alias', $args['year'])->first();

        if (!$page) {
            $page['title'] = 'Скачать игры ' . $args['year'] . ' года';
            $page['meta_d'] = '';
            $page['text'] = '';
        }

        $pageNumber = isset($args['pageNumber']) ? (int)$args['pageNumber'] : 1;

        //$pageData['title_seo'] = $page->title_seo ? $page->title_seo : $page->title;
        //$pageData['title'] = $page->title;
        //$pageData['alias'] = $page->alias;

        $limit = 9;
        if ($pageNumber > 1) {
           $offset = ($pageNumber-1)*$limit;

            $games = Game::where('status', 1)
                ->orderBy('date_release', 'desc')
                ->skip($offset)
                ->take($this->container->get('settings')['pagination']['itemsPerPage'])
                ->get();

        } else {
            $games = Game::where([
                ['status', '=', 1],
                ['date_release', '>=', $args['year'] . '-01-01'],
                ['date_release', '<=', $args['year'] . '-12-31']
            ])
                ->orderBy('date_release', 'desc')
                ->take($this->container->get('settings')['pagination']['itemsPerPage'])
                ->get();
        }


        $totalGames = Game::where([
            ['status', '=', 1],
            ['date_release', '>=', $args['year'] . '-01-01'],
            ['date_release', '<=', $args['year'] . '-12-31']]
        )->count();

        /** @var PhpRenderer $view */
        $view = $this->container->view;
        $paginator = new PaginatorService($this->container);
        //$paginator->setCategoryAlias($category);
        $paginator->setCurrentPage($pageNumber);
        $paginator->setItemsPerPage($this->container->get('settings')['pagination']['itemsPerPage']);
        $paginator->setMaxPaginationElements($this->container->get('settings')['pagination']['maxPaginationElements']);
        $paginator->setTotalPages(ceil(($totalGames/$this->container->get('settings')['pagination']['itemsPerPage'])));

        return $view->render($response, 'layout.php', [
            'subtemplate' => 'mainpage',
            'pageData' => $page,
            'games' => $games,
            'paginator' => $paginator,
            'textLogo' => $this->container->settings['textLogo']
        ]);
    }

}