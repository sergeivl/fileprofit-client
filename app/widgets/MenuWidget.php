<?php namespace App\Widgets;

class MenuWidget extends Widget
{
    public function __construct($columns = [])
    {
        $this->html .= $this->getBeginMenu();
        $this->html .= $this->getItemsOfMenu($columns);
        $this->html .= $this->getEndMenu();

    }

    private function getItemsOfMenu($columns)
    {
        foreach ($columns as $column) {
            $class = $column['is_active'] ? 'active' : '';
            $this->html .= "<li class=\"$class\"><a href=\"/$column[link]\">$column[name]</a>";

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
            <a class="navbar-brand" href="/"><span style="color:#5cb85c;">Tut</span>-Games.Ru</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">';
    }

    private function getEndMenu()
    {
        return '</ul>
        </div><!--/.nav-collapse -->
        </div>
        </nav>';
    }

}