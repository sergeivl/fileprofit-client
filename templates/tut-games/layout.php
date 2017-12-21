<?php
/** @var array $pageData */

use App\Widgets\MenuWidget;

/** @var string $subtemplate */
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="<?= @$pageData['meta_d'] ?>">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="/themes/tut-games/css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="/img/unikgames.png"/>


    <title><?= isset($pageData['title_seo']) ? $pageData['title_seo'] : $pageData['title'] ?></title>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

</head>

<body>


<?php
if (!isset($pageData['alias'])) {
    $pageData['alias'] = null;
}
$columns = [
    [
        'name' => 'Все игры',
        'link' => '/',
        'is_active' => $pageData['alias'] === 'main',
        'visible' => true
    ],
    [
        'name' => 'Action',
        'link' => 'action',
        'is_active' => $pageData['alias'] === 'action',
        'visible' => true
    ],
    [
        'name' => 'Стратегии',
        'link' => 'strategy',
        'is_active' => $pageData['alias'] === 'strategy',
        'visible' => true
    ],
    [
        'name' => 'RPG',
        'link' => 'rpg',
        'is_active' => $pageData['alias'] === 'rpg',
        'visible' => true
    ],
    [
        'name' => 'Аркады',
        'link' => 'arcade',
        'is_active' => $pageData['alias'] === 'arcade',
        'visible' => true
    ],

    [
        'name' => 'Приключения',
        'link' => 'quest',
        'is_active' => $pageData['alias'] === 'quest',
        'visible' => true
    ],
    [
        'name' => 'Гонки',
        'link' => 'race',
        'is_active' => $pageData['alias'] === 'race',
        'visible' => true
    ],

    [
        'name' => 'Файтинги',
        'link' => 'fighting',
        'is_active' => $pageData['alias'] === 'fighting',
        'visible' => true
    ],

    [
        'name' => 'Спорт',
        'link' => 'sport',
        'is_active' => $pageData['alias'] === 'sport',
        'visible' => true
    ],
    [
        'name' => 'Симулятор',
        'link' => 'simulator',
        'is_active' => $pageData['alias'] === 'sport',
        'visible' => true
    ]

];
$menu = new MenuWidget($columns);
echo $menu;
?>

<?php require '_' . $subtemplate . '.php' ?>

<footer class="container">
    <div class="row fp-footer">
        <div class="col-xs-6">
            <a href="http://tut-games.ru/">Tut-Games.Ru</a> - скачать игры на русском бесплатно через торрент
        </div>
        <div class="col-xs-6" style="text-align:right;">
            <!--LiveInternet counter-->
            <script type="text/javascript"><!--
                document.write("<a href='//www.liveinternet.ru/click' " +
                    "target=_blank><img src='//counter.yadro.ru/hit?t44.5;r" +
                    escape(document.referrer) + ((typeof(screen) == "undefined") ? "" :
                        ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
                        screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
                    ";" + Math.random() +
                    "' alt='' title='LiveInternet' " +
                    "border='0' width='31' height='31'><\/a>")
                //--></script><!--/LiveInternet-->

        </div>
    </div>
</footer>

</body>
</html>