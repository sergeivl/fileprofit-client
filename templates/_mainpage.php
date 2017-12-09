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

    foreach ($games as $game) {
        require '_gameItem.php';
    }

    ?>

    <div class="clearfix"></div>

    <?php require '_pagination.php'; ?>
    <div class="clearfix"></div>

</div>

