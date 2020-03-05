<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use HasSlug;
    protected $connection = 'srocms';
    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function articleCategories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_category')->enabled();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id', 'JID');
    }

    public function articleComments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopePublished($query)
    {
        return $query->where(function ($query)
        {
            $query->where('published_at', '=', null)
                ->orWhere('published_at', '<=', Carbon::now());
        });
    }
}
