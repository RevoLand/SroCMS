<?php

namespace App;

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
        return $this->hasMany(ArticleComment::class)->where('is_visible', true)->where('is_approved', true)->latest();
    }
}
