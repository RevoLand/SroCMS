<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function userComments()
    {
        return $this->hasMany(ArticleComment::class, 'user_id', 'user_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
