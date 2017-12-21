<?php namespace App\Models;

/**
 * Class User
 * @package App\Models
 * @property $name
 * @property $link
 * @property $parent
 * @property $position
 * @property $class
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

    public static function getDataForWidget($menuItems = [])
    {
        /** @var Menu[] $menuItems */
        // Разделяем элементы с родителями и без
        $parents = [];
        $childs = [];
        foreach ($menuItems as $item) {
            if ($item->parent === 0) {
               $parents[$item['id']] = [
                   'id' => $item->id,
                   'itemName' => $item->name,
                   'childs' => [],
                   'parent' => $item->parent
               ];
            } else {
                $childs[$item->id] = [
                    'id' => $item->id,
                    'itemName' => $item->name,
                    'childs' => [],
                    'parent' => $item->parent
                ];
            }
        }

        foreach ($childs as $child) {
            if (isset($parents[$child['parent']])) {
                $parents[$child['parent']]['childs'][] = $child;
            }
        }

        return $parents;

    }

}