<?php
/** @var array $pageData */
/** @var string $subtemplate */
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="<?= isset($pageData['meta_d']) ? $pageData['meta_d'] : '' ?>">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="/themes/tut-games/css/style.css" rel="stylesheet" type="text/css">
    <link href="/themes/admin/css/admin.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="/img/unikgames.png"/>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" />



    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nestedSortable/2.0.0/jquery.mjs.nestedSortable.min.js"></script>

    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/ckeditor/adapters/jquery.js"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>



    <title><?= isset($pageData['title_seo']) ? $pageData['title_seo'] : (isset($pageData['title']) ? $pageData['title'] : '' ) ?></title>
</head>

<body>


<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin/"><span style="color:#5cb85c;">File</span>Profit Admin</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/admin/">Игры</a></li>
                <li><a href="/admin/categories">Категории</a></li>
                <li><a href="/admin/pages">Страницы</a></li>
                <li><a href="/admin/menu">Меню</a></li>
                <li><a style="color:#5cb85c;" href="/">Перейти на сайт</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container" style="background: white">
    <div class="row">
        <div class="col-md-10">
            <?php require '_' . $subtemplate . '.php' ?>
        </div>
    </div>
</div>
<footer class="container">
    <div class="row fp-footer">
        <div class="col-xs-6">
            <a href="">FileProfit Admin
            </a>
        </div>
        <div class="col-xs-6" style="text-align:right;">


        </div>
    </div>
</footer>

</body>
</html>