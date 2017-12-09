<?php namespace App\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Services\PaginatorService;
use Slim\Views\PhpRenderer;

class CategoryController extends Controller
{
    public function show($request, $response, $args)
    {
        $category = $args['category'];
        $page = Category::where('alias', $category)->first();
        $pageNumber = isset($args['pageNumber']) ? (int)$args['pageNumber'] : 1;

        $pageData['title_seo'] = $page->title_seo ? $page->title_seo : $page->title;
        $pageData['title'] = $page->title;
        $pageData['alias'] = $page->alias;

        $limit = 9;
        if ($pageNumber > 1) {
           $offset = ($pageNumber-1)*$limit;

            $games = Game::whereHas('taxonomy', function ($query) use ($page) {
                $query->where('category_id', '=', $page->id);
            })
                ->orderBy('date_release', 'desc')
                ->skip($offset)
                ->take($this->container->get('settings')['pagination']['itemsPerPage'])
                ->get();

        } else {
            $games = Game::whereHas('taxonomy', function ($query) use ($page) {
                $query->where('category_id', '=', $page->id);
            })
                ->orderBy('date_release', 'desc')
                ->take($this->container->get('settings')['pagination']['itemsPerPage'])
                ->get();

        }


        $totalGames = Game::withTaxonomy($page->id)->count();
        /** @var PhpRenderer $view */
        $view = $this->container->view;
        $paginator = new PaginatorService($this->container);

        $paginator->setCategoryAlias($category);
        $paginator->setCurrentPage($pageNumber);
        $paginator->setItemsPerPage($this->container->get('settings')['pagination']['itemsPerPage']);
        $paginator->setMaxPaginationElements($this->container->get('settings')['pagination']['maxPaginationElements']);
        $paginator->setTotalPages(ceil(($totalGames/$this->container->get('settings')['pagination']['itemsPerPage'])));

        return $view->render($response, 'layout.php', [
            'subtemplate' => 'mainpage',
            'pageData' => $pageData,
            'games' => $games,
            'paginator' => $paginator
        ]);
    }

}