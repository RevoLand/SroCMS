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
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }
}
