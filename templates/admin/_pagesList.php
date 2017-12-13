<h1>Список страниц</h1>

<table class="table">
    <tr>
        <th>Игра</th>
        <th>Действия</th>
    </tr>
    <?php
    foreach ($pages as $page):
        ?>
        <tr class="" data-page-id="<?= $page->id ?>" data-page-title="<?= $page->title ?>">
            <td>
                <a href="/admin/page/<?= $page->id ?>">
                    <?= $page->title ?>
                </a>
            </td>
            <td class="list-actions">
                <a href="/admin/page/<?= $page->id ?>" data-toggle="tooltip" data-placement="top" title="Редактировать">
                    <i class="glyphicon glyphicon-edit"></i>
                </a>
                <a href="#delete" class="delete" data-toggle="tooltip" data-placement="top" title="Удалить">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>

                <a href="#change-status" class="status-lurk <?= $page->status === 'published' ? '' : 'hide' ?>">
                    <i class="glyphicon glyphicon-eye-close" data-toggle="tooltip" data-placement="top" title="Снять с публикации"></i>
                </a>
                <a href="#change-status" class="status-public <?= $page->status === 'published' ? 'hide"' : '' ?>">
                    <i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="Опубликовать"></i>
                </a>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>