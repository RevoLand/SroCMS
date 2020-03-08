<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ArticleCategory extends Model
{
    use HasSlug;
    protected $connection = 'srocms';
    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category');
    }

    public function scopeEnabled($query)
    {
        return $query->where('Enabled', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
