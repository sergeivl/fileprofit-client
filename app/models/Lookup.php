<?php namespace App\Models;

/**
 * Class User
 * @property integer $id
 * @property string $name
 * @property integer $code
 * @property string $type
 * @property integer $position
 */
class Lookup extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'id',
        'name',
        'code',
        'type',
        'position'
    ];


}
