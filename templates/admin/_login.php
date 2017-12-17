<?php
/** @var TYPE_NAME $pageData */
?>

<h1><?= $pageData['title'] ?></h1>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">Введите логин и пароль</div>
            <div class="panel-body">
                <form action="" method="post" name="login">
                    <div class="form-group">
                        <label for="alias">Alias:</label>
                        <input class="form-control" name="login" placeholder="Ваш логин" value="" id="alias">
                    </div>

                    <div class="form-group">
                        <label for="status">Статус:</label>
                        <input class="form-control" name="password" type="password" placeholder="Ваш пароль" value="" id="status">
                    </div>

                    <button value="save" class="btn btn-primary">Войти</button>
                </form>

            </div>
        </div>
    </div>
</div>
