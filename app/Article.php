<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $connection = 'srocms';
    protected $table = 'articles';
    protected $guarded = [];

    public function Category()
    {
        return $this->belongsTo('App\ArticleCategory', 'category_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'author_id', 'JID');
    }

    public function Comments()
    {
        return $this->hasMany('App\ArticleComment', 'article_id', 'id')->where('is_visible', true)->where('is_approved', true)->orderByDesc('updated_at');
    }
}
