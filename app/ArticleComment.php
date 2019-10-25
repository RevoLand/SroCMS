<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $connection = 'srocms';
    protected $table = 'articles_comments';
    protected $guarded = [];

    public function Article()
    {
        return $this->belongsTo('App\Article', 'article_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id', 'JID');
    }
}
