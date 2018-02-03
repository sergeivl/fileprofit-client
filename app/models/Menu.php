<?php namespace App\Models;

/**
 * Class User
 * @package App\Models
 * @property string $name
 * @property string $link
 * @property integer $parent
 * @property integer $position
 * @property string $class
 */
class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'name',
        'link',
        'parent',
        'position',
        'class'
    ];

    public function setUpdatedAt($value)
    {
        //Do-nothing
    }

    public function getUpdatedAtColumn()
    {
        //Do-nothing
    }

    public function setCreatedAt($value)
    {
        //Do-nothing
    }

    /**
     * @param Menu[] $menuItems
     * @param string $alias
     * @return array
     */
    public static function getDataForWidget($menuItems = [], $alias = null)
    {

        /** @var Menu[] $menuItems */
        // Разделяем элементы с родителями и без
        $parents = [];
        $children = [];
        foreach ($menuItems as $item) {
            if (!$item->parent) {
               $parents[$item->id] = [
                   'id' => $item->id,
                   'itemName' => $item->name,
                   'children' => [],
                   'parent' => $item->parent,
                   'link' => $item->link,
                   'is_active' => '',
                   'visible' => true,
                   'class' => $item->class . $item->link === $alias ? ' active' : ''
               ];
            } else {
                $children[$item->id] = [
                    'id' => $item->id,
                    'itemName' => $item->name,
                    'children' => [],
                    'parent' => $item->parent,
                    'link' => $item->link,
                    'visible' => true,
                    'class' => $item->class . $item->link === $alias ? ' active' : ''
                ];
            }
        }



        foreach ($children as $child) {
            if (isset($parents[$child['parent']])) {
                $parents[$child['parent']]['children'][] = $child;
            }
        }

        return $parents;

    }

}