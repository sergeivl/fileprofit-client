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