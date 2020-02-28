<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable, SluggableScopeHelpers;

    protected $connection = 'srocms';
    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function scopeEnabled($query)
    {
        return $query->whereEnabled(true);
    }
}
