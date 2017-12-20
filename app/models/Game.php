<?php namespace App\Models;

/**
 * Class User
 * @property string $title
 * @property string $seo_title
 * @property string $alias
 * @property string $name
 * @property string $meta_d
 * @property string $content
 * @property string $status
 * @property string $date_release
 * @property string $genre
 * @property string $rating
 * @property string $more_info
 * @property string $system_requirements
 * @property string $developer
 * @property string $trailer
 * @property string $publisher
 * @property string $review
 * @property string $screenshots
 * @property string $torrent
 * @property string $cover
 * @property string $operatingSystem
 * @property string $processorRequirements
 * @property string $memoryRequirements
 * @property string $storagerequirements
 * @property string $videocard
 * @property string $fileSize
 *
 * @property array $taxonomy
 * @package App\Models
 */

class Game extends Model
{
    protected $fillable = [
        'title',
        'title_seo',
        'name',
        'meta_d',
        'content',
        'alias',
        'status',
        'date_release',
        'more_info',
        'system_requirements',
        'developer',
        'genre',
        'rating',
        'trailer',
        'publisher',
        'review',
        'screenshots',
        'torrent',
        'cover',
        'operatingSystem',
        'processorRequirements',
        'memoryRequirements',
        'storagerequirements',
        'videocard',
        'fileSize'
    ];

    public static function withTaxonomy ($categoryId)
    {
        return static::leftJoin(
            'taxonomy',
            'taxonomy.game_id', '=', 'games.id'
        )->where('taxonomy.category_id', $categoryId);
    }

    public function taxonomy()
    {
        return $this->hasMany('App\Models\Taxonomy', 'game_id', 'id');
    }

    public function getGameLink()
    {
        foreach ($this->taxonomy as $taxonomy){
            if ($taxonomy->is_main) {
                return '/' . $taxonomy->category->alias . '/' . $this->alias;
            }
        }
        return null;
    }

    public function getMainCategoryId()
    {
        foreach ($this->taxonomy as $taxonomy){
            if ($taxonomy->is_main) {
                return $taxonomy->category->id;
            }
        }
        return null;
    }

}
