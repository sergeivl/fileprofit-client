<?php
/** @var array $pageData */
/** @var array $games */
/** @var \App\Services\PaginatorService $paginator */
?>
<div class="container fp-template">
    <div class="content-list">
        <h1><?= $pageData['title'] ?></h1>
    </div>

    <div class="clearfix"></div>

    <?php
    if (count($games) > 0) {
        foreach ($games as $game) {
            require '_gameItem.php';
        }
        ?>
        <div class="clearfix"></div>

        <?php
    } else {
        echo '<p>Игры не найдены</p>';
    }

    ?>

</div>