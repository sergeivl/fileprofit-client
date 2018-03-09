<?php namespace App\Services;

use App\Models\Game;
use App\Models\Taxonomy;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\Config\Definition\Exception\Exception;

class GamesSaveService extends Service
{
    /*
    * Выгрузка и сохранение категорий с API
    **/
    const GAME_TYPE = 'TutGames';

    public function saveAllGames()
    {
        $offset = 0;
        $count = 1;
        while ($games = $this->getGames(5, $offset)) {
            // Сохраняем игры
            foreach ($games as $game) {

                // Проверяем, есть ли игра
                $model = Game::where('alias', $game['alias'])->first();
                if (!empty($model)) {
                    $this->container['logger']->addInfo($count . ') Игра ' . $game['alias'] . ' уже есть в базе');
                    $count++;
                    continue;
                }

                $model = new Game;

                // Сохраняем текстовые поля
                $model->title = $game['title'];
                $model->seo_title = $game['seo_title'];
                $model->name = $game['name'];
                $model->meta_d = mb_strimwidth ( $game['meta_description'], 0, 255);
                $model->content = $game['content'];
                $model->alias = $game['alias'];
                $model->date_release = date('Y-m-d', $game['date_release']);

                $model->operatingSystem = $game['operatingSystem'];
                $model->processorRequirements = $game['processorRequirements'];
                $model->memoryRequirements = $game['memoryRequirements'];
                $model->storagerequirements = $game['storagerequirements'];
                $model->videocard = $game['videocard'];
                $model->fileSize = $game['fileSize'];
                $model->status = 0;

                $model->trailer = $game['trailer'];
                $model->developer = $game['developer'];
                $model->publisher = $game['publisher'];
                $model->review = $game['review'];
                $model->genre = $game['genre'];
                $model->rating = $game['rating'];

                // Сохраняем обложку
                $model->cover = $this->saveCover($model, $game);

                // Сохраняем скриншоты
                $model->screenshots = $this->saveScreenshots($model, $game);

                // Сохраняем торрент
                $model->torrent = $this->saveTorrent($model, $game);

                if ($model->torrent === false) {
                    continue;
                }


                $model->save();

                $this->addTaxonomy($model, $game);
                $this->clearUnnecessaryTaxonomy($model, $game);

                $this->container['logger']->addInfo($count . ') ' . $game['alias']);
                $count++;
            }
            $offset = $games[count($games) - 1]['id'];
            sleep(3);
        }

    }

    public function updateAllGames($fields)
    {
        if (empty($fields)) {
            $this->container['logger']->addInfo('Типа обновляем все поля');
            exit;
        }

        $offset = 0;
        $count = 1;
        while ($games = $this->getGames(5, $offset)) {
            // Сохраняем игры
            foreach ($games as $game) {
                // Проверяем, есть ли игра
                $model = Game::where('alias', $game['alias'])->first();
                if (empty($model)) {
                    continue;
                }
                foreach ($fields as $field) {
                    $model->$field = $game[$field];
                }
                $model->save();
                $this->container['logger']->addInfo($count . ') Обновление ' . $game['alias']);
                $count++;

            }
            $offset = $games[count($games) - 1]['id'];
        }
    }

    private function getGames($limit, $offset)
    {
        $client = new Client();
        $games = [];
        try {
            $res = $client->request(
                'GET',
                $this->container->settings['api']
                . "/api/get-games?limit=$limit&offset=$offset"
                . ($this->container->settings['games_content_type'] ? '&contentType='
                . $this->container->settings['games_content_type'] : '')
                . '&token=' . $this->container->settings['token']
            );

            if ($res->getStatusCode() === 200) {
                //$games = \GuzzleHttp\json_decode($res->getBody(), true);
                $games = json_decode($res->getBody(), true);
            } else {
                $error = json_decode($res->getBody(), true);
                print_r($error);
                exit($games);
            }

            if (isset($games['code']) && $games['code'] === 400) {
                echo $games['message'] . PHP_EOL;
                exit();
            }


        } catch (RequestException $e) {
            $this->container['logger']->addError('cURL error 18');
        }


        if (!is_array($games) || count($games) === 0) {
            return false;
        }
        return $games;
    }

    private function saveCover(Game $model, $game)
    {
        $parts = explode('.', $game['cover']);
        $ext = $parts[count($parts) - 1];
        $coverPath = WEB_ROOT . 'img/covers/' . $model->alias . '.' . $ext;
        if (!file_exists($coverPath)) {
            $this->saveFile(
                $game['cover'],
                $coverPath
            );
            $this->uniquelyImg($coverPath);
        }

        return '/' . $coverPath;
    }

    private function uniquelyImg($imgPath)
    {
        $img = Image::make($imgPath);
        $img->text($this->container->settings['watermark'], 4, 15, function ($font) {
            $font->file(WEB_ROOT . 'fonts/Astakhov-Access-Degree-Sk.ttf');
        });
        $img->colorize(rand(0, 10), rand(0, 10), rand(0, 10));
        $img->save($imgPath);
    }

    private function saveScreenshots(Game $model, $game)
    {
        $result = [];
        if (!isset($game['screenshots']) || empty($game['screenshots'])) {
            return '';
        }
        $screenshots = explode(';', $game['screenshots']);

        foreach ($screenshots as $key => $screenshot) {
            $parts = explode('.', $screenshot);
            $ext = $parts[count($parts) - 1];

            $path = WEB_ROOT . 'img/screenshots/' . $model->alias . '_' . strval($key + 1) . '.' . $ext;

            if (!file_exists($path)) {
                $this->saveFile(
                    $screenshot,
                    $path
                );
                $this->uniquelyImg($path);
            }

            $result[] = '/' . $path;
        }
        return \GuzzleHttp\json_encode($result);
    }

    private function saveTorrent($model, $game)
    {

        $parts = explode('.', $game['torrent']);
        $ext = $parts[count($parts) - 1];
        $torrentPath = WEB_ROOT . 'torrents/' . $model->alias . '.' . $ext;

        if (empty($game['torrent'])) {
            $this->container['logger']->addError('Торрент файл отсутствует');
            return false;
        }

        $this->saveFile(
            $game['torrent'],
            $torrentPath
        );
        return '/' . $torrentPath;


    }


    private function saveFile($url, $path)
    {

        try {
            $client = new Client();
            $client->request('GET', $url, [
                'sink' => $path,
            ]);
        } catch (RequestException $e) {
            $this->container['logger']->addError('Не удалось сохранить файл "' . $url . '". cURL error 18');
            exit;
        } catch (Exception $exception) {
            $this->container['logger']->addError('Не удалось сохранить ' . $url);

        }
        return '';
    }

    private function clearUnnecessaryTaxonomy($model, $game)
    {
        $taxonomies = Taxonomy::where('game_id', $model->id)->get();

        foreach ($taxonomies as $taxonomy) {
            $delete = true;
            foreach ($game['gamesTaxonomies'] as $tax) {
                if ((int)$tax['category_id'] === $taxonomy->category_id) {
                    $delete = false;
                    break;
                }
            }
            if ($delete) {
                $taxonomy->delete();
            }
        }

    }


    private function addTaxonomy(Game $model, $game)
    {

        foreach ($game['gamesTaxonomies'] as $tax) {

            $taxonomy = Taxonomy::whereRaw(
                'game_id = ? AND category_id = ?',
                [$model->id, $tax['category_id']]
            )->first();

            if (!empty($taxonomy)) {
                continue;
            }

            $taxonomy = new Taxonomy;
            $taxonomy->game_id = $model->id;
            $taxonomy->category_id = $tax['category_id'];
            $taxonomy->is_main = $tax['is_main'];
            $taxonomy->save();

        }
    }

    private function updateTaxonomy(Game $model, $game)
    {

    }

}