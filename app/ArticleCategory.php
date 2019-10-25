<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $connection = 'srocms';
    protected $table = 'articles_categories';
    protected $guarded = [];
}
