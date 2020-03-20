<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function getUrlAttribute()
    {
        switch($this->type)
        {
            case 1:
                return $this->href;
            case 2:
                return route('pages.show_page', $this->page->slug);
            case 3:
                return route($this->route);
        }

    }

    public function getTitle()
    {
        if ($this->type == 2)
        {
            return $this->page->title;
        }

        return $this->title;
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->orderBy('order');
    }

    public function childrens()
    {
        return $this->children()->with('childrens');
    }

    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeViewPermissions($query)
    {
        return $query->where(function ($query)
        {
            if (Auth::check())
            {
                $query->where('users_can_view', true);
            }
            else
            {
                $query->where('guests_can_view', true);
            }
        });
    }
}
