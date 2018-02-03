<?php
/** @var App\Models\Game $game */
?>

<div>
    <a href="/download/1884.html" ><img alt="Скачать" style="width: 240px;" src="/download/dbutton.png"></a>
</div>
<div style="margin-top: 8px; width: 150px; text-align: center;">
    <a style="color:forestgreen;" href="<?= $game->torrent ?>">[Торрент <?= $game->fileSize ?>]</a>
</div>
