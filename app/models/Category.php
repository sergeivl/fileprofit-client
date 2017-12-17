<?php namespace App\Models;

/**
 * Class User
 * @property string $title
 * @property string $title_seo
 * @property string $alias
 * @property string $text
 * @property string $status
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

    public function loadData($data)
    {
        $this->title = $data['title'];
        $this->title_seo = $data['title_seo'];
        $this->meta_d = $data['meta_d'];
        $this->text = $data['text'];
        $this->alias = $data['alias'];
        $this->status = $data['status'];
    }

}