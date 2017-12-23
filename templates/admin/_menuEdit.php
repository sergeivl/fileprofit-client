<?php
/** @var array $menuItems */
?>

<div class="row" style="margin-top: 30px;">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Добавить пункт меню</div>
            <div class="panel-body">
                <form method="post" name="menu">
                    <div class="form-group">
                        <label for="itemName">Элемент меню</label>
                        <input type="text" class="form-control" id="itemName" name="itemName" placeholder="Название элемента меню">
                        <small id="itemNameHelp" class="form-text text-muted">Введите название элемента меню</small>
                    </div>

                    <div class="form-group">
                        <label for="itemName">Ссылка</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="Ссылка на страницу">
                        <small id="itemNameHelp" class="form-text text-muted">
                            Укажите абсолютную или относительную ссылку на страницу
                        </small>
                    </div>

                    <button class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Другие действия</div>
            <div class="panel-body">
                <button class="btn btn-info" id="add-categories">Добавить категории в меню</button>
            </div>
        </div>

    </div>
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading">Сортировка пунктов</div>
            <div class="panel-body">

                <?= (new \App\Widgets\SortingMenuWidget($menuItems)) ?>
            </div>
        </div>
    </div>
</div>


<!-- HTML-код модального окна -->
<div id="editMenuItemModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Редактирование пункта меню «<span id="modal-item-name"></span>»</h4>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
                <form method="post" name="item-menu-edit" id="item-menu-edit" action="/admin/edit-item-menu">
                    <input type="hidden" class="form-control" value="" id="itemMenuElementId" name="itemMenuElementId">
                    <div class="form-group">
                        <label for="itemName">Элемент меню</label>
                        <input class="form-control" id="itemMenuName" value="" name="itemMenuName" placeholder="Название элемента меню">
                        <small id="itemNameHelp" class="form-text text-muted">Введите название элемента меню</small>
                    </div>

                    <div class="form-group">
                        <label for="itemName">Ссылка</label>
                        <input type="text" class="form-control" id="itemMenuLink" name="item-menu-link" placeholder="Ссылка на страницу">
                        <small id="itemNameHelp" class="form-text text-muted">
                            Укажите абсолютную или относительную ссылку на страницу
                        </small>
                    </div>
                </form>
            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="send-edited-item">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>


<!-- HTML-код модального окна -->
<div id="deleteMenuItemModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Удаление пункта меню «<span id="delete-item-name"></span>»</h4>
            </div>
            <div class="modal-body">
                Вы действительно хотите удалить данный пункт меню?
                <form method="post" name="item-menu-delete" id="item-menu-delete" action="/admin/delete-item-menu">
                    <input type="hidden" class="form-control" value="" id="itemMenuElementIdForDelete" name="itemMenuElementIdForDelete">
                </form>
            </div>
            <!-- Футер модального окна -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-danger" id="send-delete-item">Удалить</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="/js/admin-menu.js"></script>