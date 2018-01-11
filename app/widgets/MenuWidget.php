<?php namespace App\Widgets;

use App\Models\Menu;

class MenuWidget extends Widget
{
    private $textLogo;
    public function __construct($columns = [], $textLogo = null)
    {
        $this->textLogo = $textLogo;
        $this->html .= $this->getBeginMenu();
        $this->html .= $this->getItemsOfMenu($columns);
        $this->html .= $this->getEndMenu();
    }

    private function getItemsOfMenu($columns)
    {
        //print_r($columns);
        foreach ($columns as $column) {
            if (!$column['children']) {
                $this->html .= "<li class=\"$column[class]\"><a href=\"$column[link]\">$column[itemName]</a></li>";
            } else {
                $this->html .= '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '. $column['itemName'] .' <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                ';

                foreach ($column['children'] as $child) {
                    $this->html .= "<li class=\"$child[class]\"><a href=\"$child[link]\">$child[itemName]</a></li>";
                }

                $this->html .= '</ul></li>';
            }
        }
    }

    private function getBeginMenu()
    {
        return '
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
                        <a class="navbar-brand" href="/"> '. $this->textLogo .'</a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">';
    }

    private function getEndMenu()
    {
        return '
                     </ul>
                     <ul class="nav navbar-nav navbar-right">
            <form class="navbar-form" role="search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Найти игру" id="q">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="button" onclick="window.location=\'/search/\' + $(this).parent().prev().val()"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></button>
                </div>
            </div>
            </form>  
    </ul>
                     
                 </div><!--/.nav-collapse -->
             </div>
        </nav>';
    }

}