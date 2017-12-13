<?php namespace App\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Models\Page;
use App\Models\Taxonomy;
use App\Services\PaginatorService;
use Illuminate\Database\DatabaseManager;
use Slim\Container;
use Slim\Http\Request;
use Slim\Views\PhpRenderer;
use Illuminate\Database\Capsule\Manager as Capsule;

class AdminController extends Controller
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $container['view'] = function (Container $c) {
            return new PhpRenderer($c['settings']['templatesPath'] . '/admin');
        };
    }

    public function gameEdit(Request $request, $response, $args)
    {

        /** @var array $args */
        $game = Game::where('id', $args['id'])->first();

        if($request->isPost()) {
            echo 'Сохраняем игру';
            $data = $request->getParsedBody();
            // Сохраняем игру
            die();
        }

        $pageData['title_seo'] = $game->title_seo ? $game->title_seo : $game->title;
        $pageData['title'] = $game->title;
        // $pageData['alias'] = $args['gameAlias'];

        /** @var PhpRenderer $view */
        $view = $this->container->view;

        return $view->render($response, 'admin.php', [
            'subtemplate' => 'adminGame',
            'pageData' => $pageData,
            'game' => $game
        ]);
    }

    public function gameList($request, $response, $args)
    {
        $category = isset($args['category']) ? $args['category'] : null;

        if ($category !== null) {
            $page = Category::where('alias', $category)->first();
            $pageData['title_seo'] = $page->title_seo ? $page->title_seo : $page->title;
            $pageData['title'] = $page->title;
            $pageData['alias'] = $page->alias;
        } else {
            $pageData['title_seo'] = 'Админка';
            $pageData['title'] =  'Админка';
            $pageData['alias'] = 'admin';
        }

        $pageNumber = isset($args['pageNumber']) ? (int)$args['pageNumber'] : 1;



        $limit = 50;
        if ($pageNumber > 1) {
            $offset = ($pageNumber - 1) * $limit;

            if ($category !== null) {
                $games = Game::whereHas('taxonomy', function ($query) use ($page) {
                    $query->where('category_id', '=', $page->id);
                })
                    ->orderBy('date_release', 'desc')
                    ->skip($offset)
                    ->take($limit)
                    ->get();
            } else {
                $games = Game::orderBy('date_release', 'desc')
                    ->skip($offset)
                    ->take($limit)
                    ->get();
            }


        } else {
            if ($category !== null) {
                $games = Game::whereHas('taxonomy', function ($query) use ($page) {
                    $query->where('category_id', '=', $page->id);
                })
                    ->orderBy('date_release', 'desc')
                    ->take($limit)
                    ->get();
            } else {
                $games = Game::orderBy('date_release', 'desc')
                    ->take($limit)
                    ->get();
            }

        }

        if ($category !== null) {
            $totalGames = Game::whereHas('taxonomy', function ($query) use ($page) {
                $query->where('category_id', '=', $page->id);
            })->count();
        } else {
            $totalGames = Game::all()->count();
        }


        /** @var PhpRenderer $view */
        $view = $this->container->view;
        $paginator = new PaginatorService($this->container);

        $paginator->setCategoryAlias('admin/' . $category);
        $paginator->setCurrentPage($pageNumber);
        $paginator->setItemsPerPage($this->container->get('settings')['pagination']['itemsPerPage']);
        $paginator->setMaxPaginationElements($this->container->get('settings')['pagination']['maxPaginationElements']);
        $paginator->setTotalPages(ceil(($totalGames / $limit)));

        return $view->render($response, 'admin.php', [
            'subtemplate' => 'adminList',
            'pageData' => $pageData,
            'games' => $games,
            'paginator' => $paginator
        ]);

    }

    public function gameDelete($request, $response, $args)
    {
        $game = Game::where('id', $args['id'])->first();
        $gameTaxonomy = Taxonomy::where('game_id', $game->id);

        try {
            $game->delete();
            $gameTaxonomy->delete();
            Capsule::commit();

            $result = [
                'action' => 'delete',
                'id' => $game->id,
                'status' => 'success'
            ];

        } catch (\Exception $e) {
            Capsule::rollback();

            $result = [
                'action' => 'delete',
                'id' => $game->id,
                'status' => 'error'
            ];
        }

        return $response->withJson($result, 200);

    }

    public function gameChangeStatus($request, $response, $args) {

        $game = Game::where('id', $args['id'])->first();

        $game->status = $game->status === 'published' ? 'not_published' : 'published';

        try {
            Capsule::beginTransaction();
            $game->save();
            Capsule::commit();

            $result = [
                'action' => 'change_status',
                'id' => $game->id,
                'status' => 'success',
                'current_value' => $game->status
            ];

        } catch (\Exception $e) {
            Capsule::rollback();
            $result = [
                'action' => 'change_status',
                'id' => $game->id,
                'status' => 'error',
            ];
        }
        return $response->withJson($result, 200);
    }

    public function pagesList($request, $response, $args)
    {
        $pages = Page::all();

        /** @var PhpRenderer $view */
        $view = $this->container->view;

        return $view->render($response, 'admin.php', [
            'subtemplate' => 'pagesList',
            'pages' => $pages
        ]);
    }

    public function pagesEdit($request, $response, $args)
    {

    }

    public function pagesCreate()
    {

    }

    public function categoryList()
    {

    }
    public function categoryEdit()
    {

    }

}