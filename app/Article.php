<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Sluggable, SluggableScopeHelpers;
    protected $connection = 'srocms';
    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
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
