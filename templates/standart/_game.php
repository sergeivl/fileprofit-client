<?php
/** @var App\Models\Game $game */

use App\Models\Game;

?>

<div class="container fp-template">
    <div class="col-md-9">
        <h1><?= $game->title ?></h1>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <img src="<?= $game->cover ?>" class="img-responsive" alt="<?= $game->title ?>">
                </div>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <td>Дата выхода:</td>
                        <td><?= $game->date_release ?></td>
                    </tr>
                    <tr>
                        <td>Жанр:</td>
                        <td><?= $game->genre ?></td>
                    </tr>
                    <tr>
                        <td>Разработчик</td>
                        <td><?= $game->developer ?></td>
                    </tr>
                    <tr>
                        <td>Издатель</td>
                        <td><?= $game->publisher ?></td>
                    </tr>
                    <tr>
                        <td>Рейтинг</td>
                        <td><?= $game->rating ?></td>
                    </tr>
                </table>
                <?php require_once '_downloadButton.php'; ?>
            </div>
        </div>

        <br>

        <div><?= $game->content ?></div>
        <div>
            <h2>Системные требования</h2>
            <table class="table">
                <tr>
                    <td>Процессор</td>
                    <td><?= $game->processorRequirements ?></td>
                </tr>
                <tr>
                    <td>Память</td>
                    <td><?= $game->memoryRequirements ?></td>
                </tr>
                <tr>
                    <td>Видеокарта</td>
                    <td><?= $game->videocard ?></td>
                </tr>
                <tr>
                    <td>HDD / SSD</td>
                    <td><?= $game->storagerequirements ?></td>
                </tr>
            </table>
        </div>
        <div>
            <?php
            $screenshots = json_decode($game->screenshots, true);
            foreach ($screenshots as $screenshot) {
                echo '<div class="pull-left" style="max-width:400px; height: 225px; border: 1px solid #ffffff; overflow: hidden;">
                     <a data-fancybox="gallery" href="'. $screenshot .'"><img src="' . $screenshot . '" class="img-responsive" alt="" ></a>
                    
                    </div>';
            }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-3">
        <h2>Похожие игры</h2>

        <?php
        /** @var Game[] $moreGames */
        foreach ($moreGames as $moreGame) {
            ?>
            <p>
                <a href="<?= $moreGame->getGameLink() ?>"><?= $moreGame->name ?></a>
            </p>
            <?php
        }
        ?>
    </div>
</div>
