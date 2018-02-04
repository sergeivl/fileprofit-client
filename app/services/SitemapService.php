<?php namespace App\Services;

use App\Models\Category;
use App\Models\Game;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;
use Slim\Container;

class SitemapService extends Service
{
    private $baseUrl;
    private $firstGameYear;
    private $lastGameYear;


    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->baseUrl = $this->container->settings['baseUrl'];
    }

    public function generate()
    {
        $path =  'sitemap.xml';
        $sitemap = new Sitemap($path);

        $this->addPages($sitemap);
        $this->addCategories($sitemap);
        $this->addGames($sitemap);
        $this->addYears($sitemap);
        $sitemap->write();

        echo PHP_EOL . 'Карта сайта сгенерирована' . PHP_EOL;
        echo $path . PHP_EOL;
    }


    /**
     * @param Sitemap $sitemap
     */
    private function addPages($sitemap)
    {
        $sitemap->addItem($this->baseUrl, time(), Sitemap::DAILY);
    }

    /**
     * @param Sitemap $sitemap
     */
    private function addCategories($sitemap)
    {
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap->addItem(
                $this->baseUrl . '/' . $category->alias,
                (new \DateTime($category->updated_at))->getTimestamp()
            );
        }
    }

    /**
     * @param Sitemap $sitemap
     */
    private function addYears($sitemap)
    {
        if($this->lastGameYear && $this->firstGameYear && $this->firstGameYear <= $this->lastGameYear) {
            $currentYear = $this->firstGameYear;
            do {
                $sitemap->addItem(
                    $this->baseUrl . '/year/' . $currentYear,
                    (new \DateTime())->getTimestamp()
                );
                $currentYear++;
            } while($currentYear < $this->lastGameYear);
        }
    }

    /**
     * @param Sitemap $sitemap
     */
    private function addGames($sitemap)
    {
        /** @var Game[] $games */
        $games = Game::where('status', 1)
            ->where('date_public', '<', date('Y-m-d H:i:s'))
            ->orderBy('date_release', 'asc')
            ->get();

        foreach ($games as $game) {
            $sitemap->addItem(
                $this->baseUrl . $game->getGameLink(),
                (new \DateTime($game->updated_at))->getTimestamp()
            );
        }
        $this->firstGameYear = (new \DateTime($games[0]->date_release))->format('Y');
        $this->lastGameYear = (new \DateTime($games[count($games)-1]->date_release))->format('Y');

    }


}