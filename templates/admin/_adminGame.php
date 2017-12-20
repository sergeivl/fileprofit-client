<?php
/** @var App\Models\Game $game */
?>
<div class="container fp-template">
    <h1>Редактирование игры</h1>
    <form action="" method="post" name="game" >
        <div class="form-group">
            <label for="title">Заголовок:</label>
            <input class="form-control" name="title" value="<?= $game->title ?>" id="title">
        </div>

        <div class="form-group">
            <label for="seo_title">SEO заголовок:</label>
            <input class="form-control" id="seo_title" name="seo_title" value="<?= $game->seo_title ?>" >
        </div>

        <div class="form-group">
            <label for="name">Имя игры:</label>
            <input class="form-control" id="name" name="name" value="<?= $game->name ?>">
        </div>

        <div class="form-group">
            <label for="meta_d">Meta Description:</label>
            <textarea name="meta_d" id="meta_d" style="width:100%;" rows="5"><?= $game->meta_d ?></textarea>
        </div>

        <div class="form-group">
            <label for="content">Текст игры:</label>
            <textarea id="content" name="content" style="width: 100%;" rows="15"><?= trim($game->content) ?></textarea>
        </div>



        <div class="form-group">
            <label for="alias">Алиас:</label>
            <input class="form-control" id="alias" name="alias" value="<?= $game->alias ?>">
        </div>

        <div class="form-group">
            <label for="date_release">Дата релиза:</label>
            <input class="form-control" id="date_release" name="date_release" value="<?= $game->date_release ?>">
        </div>



        <div class="form-group">
            <label for="operatingSystem">Операционная система:</label>
            <input class="form-control" name="operatingSystem" id="operatingSystem" value="<?= $game->operatingSystem ?>">
        </div>

        <div class="form-group">
            <label for="processorRequirements">Процессор:</label>
            <input class="form-control" name="processorRequirements" id="processorRequirements" value="<?= $game->processorRequirements ?>">
        </div>

        <div class="form-group">
            <label for="memoryRequirements">Оперативная память:</label>
            <input class="form-control" name="memoryRequirements" id="memoryRequirements" value="<?= $game->memoryRequirements ?>">
        </div>

        <div class="form-group">
            <label for="videocard">Видеокарта:</label>
            <input class="form-control" name="videocard" id="videocard" value="<?= $game->videocard ?>">
        </div>

        <div class="form-group">
            <label for="storagerequirements">Место на жёстком диске:</label>
            <input class="form-control" name="storagerequirements" id="storagerequirements" value="<?= $game->storagerequirements ?>">
        </div>

        <div class="form-group">
            <label for="fileSize">Объём файла:</label>
            <input class="form-control" name="fileSize" id="fileSize" value="<?= $game->fileSize ?>">
        </div>



        <div class="form-group">
            <label for="system_requirements">Системные требования:</label>
            <textarea name="" id="screenshots" name="screenshots" style="width: 100%;" rows="10"><?= $game->system_requirements ?></textarea>
        </div>

        <div class="form-group">
            <label for="trailer">Трейлер:</label>
            <textarea name="trailer" id="trailer" style="width: 100%;" rows="3"><?= $game->trailer ?></textarea>
        </div>

        <div class="form-group">
            <label for="developer">Разработчик:</label>
            <input class="form-control" id="developer" name="developer"  value="<?= $game->developer ?>">
        </div>

        <div class="form-group">
            <label for="publisher">Издатель:</label>
            <input class="form-control" id="publisher" name="publisher"  value="<?= $game->publisher ?>">
        </div>


        <div class="form-group">
            <label for="genre">Жанр:</label>
            <input class="form-control" id="genre" name="genre" value="<?= $game->genre ?>">
        </div>

        <div class="form-group">
            <label for="genre">Рейтинг:</label>
            <input class="form-control" id="rating" name="rating" value="<?= $game->rating ?>">
        </div>

        <div class="form-group">
            <label for="review">Обзор:</label>
            <textarea id="review" style="width: 100%;" rows="10" name="review"><?= $game->review ?></textarea>
        </div>
        <div class="form-group">
            <label for="torrent">Торрент:</label>
            <input class="form-control" id="torrent" name="torrent" value="<?= $game->torrent ?>">
        </div>
        <div class="form-group">
            <label for="cover">Обложка:</label>
            <input class="form-control" id="cover" name="cover" value="<?= $game->cover ?>">
        </div>

        <div class="form-group">
            <label for="screenshots">Скриншоты:</label>
            <textarea id="screenshots" name="screenshots" style="width: 100%;" rows="10"><?= $game->screenshots ?></textarea>
        </div>

        <div class="form-group">
            <label for="status">Статус:</label>
            <input class="form-control" id="status" name="status" value="<?= $game->status ?>">
        </div>
        <button class="btn btn-success">Сохранить</button>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#content').ckeditor();
    });
</script>