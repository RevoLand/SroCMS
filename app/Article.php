<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
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
