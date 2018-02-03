<?php namespace App\Widgets;

class SortingMenuWidget extends Widget
{
    public function __construct($columns = [])
    {
        $this->html .= $this->getStyles();
        $this->html .= $this->getBegin();
        $this->html .= $this->getItems($columns);
        $this->html .= $this->getEnd();
        $this->html .= $this->getJs();

    }

    private function getItems($columns)
    {

        $result = '';
        foreach ($columns as $column) {
            $result .= '<li data-menu-id="' . $column['id'] . '" data-menu-link="' . $column['link'] . '" data-menu-item-name="' . $column['itemName'] . '">
                            <div class="ui-sortable-handle pull-left"  style="width:80%;">' . $column['itemName'] . '</div>
                            <div class="pull-right">
                            <a href="#edit" class="menu-item-edit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            &nbsp;&nbsp;
                            <a href="#delete" class="menu-item-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </div>
                        <div class="clearfix"></div>
                            ';
            if (count($column['children'])) {
                $result .= '<ol>';
                foreach ($column['children'] as $children) {
                    $result .= '<li data-menu-id="' . $children['id'] . '" data-menu-link="' . $children['link'] . '" data-menu-item-name="' . $children['itemName'] . '">
                        <div class="ui-sortable-handle pull-left" style="width:80%;">' . $children['itemName'] . '</div>
                        <div class="pull-right">
                            <a href="#edit"  class="menu-item-edit"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            &nbsp;&nbsp;
                            <a href="#delete" class="menu-item-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                        </div>
                        <div class="clearfix"></div>
                        </li>';
                }
                $result .= '</ol>';
            }
            $result .= '</li>';
        }

        return $result;
    }


    private function getBegin()
    {
        return '<ol class="sortable">';
    }


    private function getEnd()
    {
        return '</ol>
            <button class="btn btn-success" id="saveMenu" type="button">Сохранить меню</button>
        ';
    }


    private function getStyles()
    {
        return '
            <style>
                .sortable {
                    padding-left: 5px;
                    list-style-type:none;
                }
                
                .sortable li {
                    list-style-type:none;
                    border-radius: 4px;
                    border: 1px solid #ccc;
                    cursor: move
                }
                
                .sortable > li {
                    padding:15px 15px;
                    margin: 15px 0;
                    background: #f8f8f8;
                }
                
                .sortable li > ol > li {
                    padding:15px 15px;
                    margin: 15px 0;
                    background: #cccccc;
                }
            </style>    
        ';
    }

    private function getJs()
    {
        return '<script type="text/javascript" src="/js/sorting-menu.js"></script>';
    }

}