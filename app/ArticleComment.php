<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $connection = 'srocms';
    protected $table = 'article_comments';
    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo('App\Article', 'article_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'JID');
    }
}
