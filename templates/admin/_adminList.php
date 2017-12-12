<?php
/** @var array $pageData */
/** @var array $games */
?>
<div class="container fp-template">
    <div class="content-list">
        <h1><?= $pageData['title'] ?></h1>
    </div>
    <div class="clearfix"></div>

    <table class="table">
        <tr>
            <th>Игра</th>
            <th>Действия</th>
        </tr>
        <?php
        foreach ($games as $game):
            ?>
            <tr class="" data-game-id="<?= $game->id ?>" data-game-name="<?= $game->name ?>">
                <td>
                    <a href="/admin/game/<?= $game->id ?>">
                        <?= $game->name ?>
                    </a>
                </td>
                <td class="list-actions">
                    <a href="/admin/game/<?= $game->id ?>" data-toggle="tooltip" data-placement="top" title="Редактировать">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    <a href="#delete" class="delete" data-toggle="tooltip" data-placement="top" title="Удалить">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>

                    <a href="#change-status" class="status-lurk <?= $game->status === 'published' ? '' : 'hide' ?>">
                        <i class="glyphicon glyphicon-eye-close" data-toggle="tooltip" data-placement="top" title="Снять с публикации"></i>
                    </a>
                    <a href="#change-status" class="status-public <?= $game->status === 'published' ? 'hide"' : '' ?>">
                        <i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="Опубликовать"></i>
                    </a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </table>

    <div class="clearfix"></div>

    <?php require '_pagination.php'; ?>
    <div class="clearfix"></div>

</div>


<!-- Modal -->
<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Подтвердите удаление</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-delete" data-dismiss="modal">Удалить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>



<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('.glyphicon-trash').click(function(){
        var gameId = $(this).closest('tr').attr('data-game-id');
        var gameName = $(this).closest('tr').attr('data-game-name');
        var confirmModal = $('#confirmModal');

        confirmModal.find('.modal-body').html('<p>Вы действительно хотите удалить ' + gameName + '?</p>');
        confirmModal.modal();
        $('.btn-delete').click(function(){
            $.get('/admin/game/delete/' + gameId);
        });
    });

    $('.glyphicon-eye-open, .glyphicon-eye-close').click(function(){
        var gameRow = $(this).closest('tr');
        var gameId = gameRow.attr('data-game-id');

        $.get('/admin/game/change-status/' + gameId, function(data) {
            if (data.status === 'success') {
                if (data.current_value === 'published') {
                    gameRow.find('.status-public').removeClass('hide');
                    gameRow.find('.status-lurk').addClass('hide');
                } else {
                    gameRow.find('.status-public').addClass('hide');
                    gameRow.find('.status-lurk').removeClass('hide');
                }
            }
        }, 'json');

    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>