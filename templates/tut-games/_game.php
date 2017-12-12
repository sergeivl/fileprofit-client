<?php
/** @var App\Models\Game $game */
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
                </table>
                <a href="<?= $game->torrent ?>">
                    <button class="btn btn-success btn-lg">
                        <i class="glyphicon glyphicon-download-alt" style="margin-right: 5px;"></i> Скачать игру
                    </button>
                </a>
            </div>
        </div>

        <br>

        <div><?= $game->content ?></div>

        <div>
            <?php
            $screenshots = json_decode($game->screenshots, true);
            foreach ($screenshots as $screenshot) {
                echo '<img src="'. $screenshot .'" class="img-responsive" alt="" ><br>';
            }
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <h2>Похожие игры</h2>
    </div>
</div>
