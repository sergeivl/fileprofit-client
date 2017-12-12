<?php
/** @var array $pageData */
/** @var array $games */
?>
<div class="container fp-template">
    <div class="content-list">
        <h1><?= $pageData['title'] ?></h1>
    </div>
    <div class="clearfix"></div>

    <?php
    if (count($games) > 0) {
        foreach ($games as $game) {
            require '_gameItem.php'; ?>

    <?php
        }
        ?>
        <div class="clearfix"></div>
        <?php
        require '_pagination.php'; ?>
        <div class="clearfix"></div>
        <?php
    } else {
        echo '<p>Нет игр</p>';
    }

    ?>


</div>

