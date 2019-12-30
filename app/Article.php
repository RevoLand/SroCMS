<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $connection = 'srocms';
    protected $table = 'articles';
    protected $guarded = [];

    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class);
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
