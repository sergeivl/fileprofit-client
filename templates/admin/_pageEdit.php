<?php
/** @var App\Models\Page $pageData */
?>

<h1>Редактирование страницы «<?= $pageData['title'] ?>»</h1>

<form action="" method="post" name="page" >
    <div class="form-group">
        <label for="title">Заголовок:</label>
        <input class="form-control" name="title" value="<?= $pageData['title'] ?>" id="title">
    </div>

    <div class="form-group">
        <label for="title_seo">SEO заголовок:</label>
        <input class="form-control" name="title_seo" value="<?= $pageData['title_seo'] ?>" id="title_seo">
    </div>

    <div class="form-group">
        <label for="meta_d">Meta Description:</label>
        <textarea class="form-control" name="meta_d" id="meta_d" style="width:100%;" rows="5"><?= $pageData['meta_d'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="text">Контент:</label>
        <textarea class="form-control" name="text" id="text" style="width:100%;" rows="5"><?= $pageData['text'] ?></textarea>
    </div>

    <div class="form-group">
        <label for="alias">Alias:</label>
        <input class="form-control" name="alias" value="<?= $pageData['alias'] ?>" id="alias">
    </div>

    <div class="form-group">
        <label for="status">Статус:</label>
        <input class="form-control" name="status" value="<?= $pageData['status'] ?>" id="status">
    </div>

    <button value="save" class="btn btn-primary">Сохранить</button>
</form>

<br><br>