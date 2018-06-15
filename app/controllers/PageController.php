<?php namespace App\Controllers;

use App\Models\Page;
use Slim\Views\PhpRenderer;

class PageController extends Controller
{
    public function show($request, $response, $args)
    {
        /** @var PhpRenderer $view */
        $view = $this->container->view;

        $pageAlias = $args['pageAlias'];
        $pageData = Page::where('alias', $pageAlias)->first();


        return $view->render($response, 'layout.php', [
            'subtemplate' => 'page',
            'pageData' => $pageData,
            'textLogo' => $this->container->settings['textLogo']
        ]);
    }

}