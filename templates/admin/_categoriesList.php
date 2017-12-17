<?php
/** @var array $categories */
?>
<h1>Список категорий</h1>
<table class="table">
    <tr>
        <th>Категория</th>
        <th>Действия</th>
    </tr>
    <?php

    foreach ($categories as $category):
        ?>
        <tr class="" data-page-id="<?= $category->id ?>" data-page-title="<?= $category->title ?>">
            <td>
                <a href="/admin/page/<?= $category->id ?>">
                    <?= $category->title ?>
                </a>
            </td>
            <td class="list-actions">
                <a href="/admin/categories/edit/<?= $category->id ?>" data-toggle="tooltip" data-placement="top" title="Редактировать">
                    <i class="glyphicon glyphicon-edit"></i>
                </a>
                <a href="#delete" class="delete" data-toggle="tooltip" data-placement="top" title="Удалить">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>

                <a href="#change-status" class="status-lurk <?= $category->status === 'published' ? '' : 'hide' ?>">
                    <i class="glyphicon glyphicon-eye-close" data-toggle="tooltip" data-placement="top" title="Снять с публикации"></i>
                </a>
                <a href="#change-status" class="status-public <?= $category->status === 'published' ? 'hide"' : '' ?>">
                    <i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="Опубликовать"></i>
                </a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>