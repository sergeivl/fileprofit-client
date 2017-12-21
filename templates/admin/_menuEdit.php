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

                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
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



