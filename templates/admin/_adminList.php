<?php
/** @var array $pageData */
/** @var array $games */
?>
<div class="fp-template">
    <div class="row">
        <div class="">
            <ul class="nav nav-pills">
                <li <?= @$pageData['alias'] === 'admin' ?  'class="active"' : ''  ?> ><a href="/admin/">Все игры</a></li>
                <li <?= @$pageData['alias'] === 'action' ?  'class="active"' : ''  ?> ><a href="/admin/action">Action</a></li>
                <li <?= @$pageData['alias'] === 'strategy' ?  'class="active"' : ''  ?> ><a href="/admin/strategy">Стратегии</a></li>
                <li <?= @$pageData['alias'] === 'rpg' ?  'class="active"' : ''  ?> ><a href="/admin/rpg">RPG</a></li>
                <li <?= @$pageData['alias'] === 'arcade' ?  'class="active"' : ''  ?> ><a href="/admin/arcade">Аркады</a></li>
                <li <?= @$pageData['alias'] === 'quest' ?  'class="active"' : ''  ?> ><a href="/admin/quest">Приключения</a></li>
                <li <?= @$pageData['alias'] === 'race' ?  'class="active"' : ''  ?> ><a href="/admin/race">Гонки</a></li>
                <li <?= @$pageData['alias'] === 'fighting' ?  'class="active"' : ''  ?> ><a href="/admin/fighting">Файтинги</a></li>
                <li <?= @$pageData['alias'] === 'sport' ?  'class="active"' : ''  ?> ><a href="/admin/sport">Спорт</a></li>
                <li <?= @$pageData['alias'] === 'simulator' ?  'class="active"' : ''  ?> ><a href="/admin/simulator">Симуляторы</a></li>
            </ul>
        </div>
    </div>

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

                    <a href="#change-status" class="status-lurk <?= $game->status  ? '' : 'hide' ?>">
                        <i class="glyphicon glyphicon-eye-close" data-toggle="tooltip" data-placement="top" title="Снять с публикации"></i>
                    </a>
                    <a href="#change-status" class="status-public <?= $game->status ? 'hide"' : '' ?>">
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
                console.log(data.current_value);
                if (!data.current_value) {
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