<?php namespace App\Models;

/**
 * Class Taxonomy
 * @property int $game_id
 * @property int $category_id
 * @property Category $category
 * @property int $is_main
 * @package App\Models
 */
class Taxonomy extends Model
{
    protected $table = 'taxonomy';
    protected $fillable = [
        'id',
        'game_id',
        'category_id',
        'is_main'
    ];
    public $timestamps = false;

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}