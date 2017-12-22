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
            $result .= '<li data-menu-id="' . $column['id'] . '"><div class="ui-sortable-handle">' . $column['itemName'] . '</div>';
            if (count($column['children'])) {
                $result .= '<ol>';
                foreach ($column['children'] as $children) {
                    $result .= '<li data-menu-id="' . $children['id'] . '"><div class="ui-sortable-handle">' . $children['itemName'] . '</div>';
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