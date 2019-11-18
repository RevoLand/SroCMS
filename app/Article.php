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
        return $this->belongsTo('App\ArticleCategory', 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'author_id', 'JID');
    }

    public function articleComments()
    {
        return $this->hasMany('App\ArticleComment', 'article_id', 'id')->where('is_visible', true)->where('is_approved', true)->orderByDesc('updated_at');
    }
}
