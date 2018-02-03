<?php
/** @var App\Models\Game $game */
?>
<div  class="pull-left game-item-block">
    <a href="<?= $game->getGameLink() ?>">
        <div class="game-item-title"><?= $game->name ?></div>
        <img src="<?= $game->cover ?>" class="img-responsive" alt="<?= $game->title ?>" >
    </a>
</div>