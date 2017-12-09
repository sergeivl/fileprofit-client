<?php namespace App\Models;

/**
 * Class User
 * @property string $title
 * @property string $title_seo
 * @property string $alias
 * @package App\Models
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'title',
        'title_seo',
        'meta_d',
        'text',
        'alias',
        'status',
    ];

}