<?php namespace App\Models;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

}