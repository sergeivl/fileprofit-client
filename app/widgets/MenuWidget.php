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
        print_r($columns);
        foreach ($columns as $column) {
            $class = $column['is_active'] ? 'active' : '';
            if (!$column['children']) {
                $this->html .= "<li class=\"$class\"><a href=\"$column[link]\">$column[name]</a>";
            } else {
                $this->html .= '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '. $column['name'] .'
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                ';

                $this->html .= '<a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Action2</a>
                                <a class="dropdown-item" href="#">Action3</a>';

                $this->html .= ' </div></li>';
            }


            /*
                  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>


             */


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
        return '
                     </ul>
                 </div><!--/.nav-collapse -->
             </div>
        </nav>';
    }

}