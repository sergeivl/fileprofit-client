<?php namespace App\Console;

use App\Controllers\Controller;
use App\Services\SitemapService;


class SitemapController extends Controller
{
    public function generate()
    {
        $service = new SitemapService($this->container);
        $service->generate();
    }

}