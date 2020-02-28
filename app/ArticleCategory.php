<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use Sluggable, SluggableScopeHelpers;
    protected $connection = 'srocms';
    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category');
    }

    public function scopeEnabled($query)
    {
        return $query->where('Enabled', true);
    }
}
