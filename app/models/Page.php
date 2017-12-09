<?php namespace App\Models;

/**
 * Class User
 * @package App\Models
 */
class Page extends Model
{
    protected $fillable = [
        'title',
        'title_seo',
        'meta_d',
        'text',
        'alias',
        'status',
    ];

}