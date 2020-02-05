<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function getHref()
    {
        if (isset($this->route))
        {
            return route($this->route);
        }

        if (isset($this->page))
        {
            return route('pages.show_page', $this->page->slug);
        }

        return $this->href;
    }

    public function getTitle()
    {
        if (isset($this->page))
        {
            return $this->page->title;
        }

        return $this->title;
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    public function scopeMain($query)
    {
        return $query->whereNull('menu_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class)->enabled()->orderBy('order');
    }

    public function childMenus()
    {
        return $this->hasMany(Menu::class)->enabled()->with('menus')->withCount('menus')->where(function ($query)
        {
            if (Auth::check())
            {
                $query->where('users_can_view', true);
            }
            else
            {
                $query->where('guests_can_view', true);
            }
        })->orderBy('order');
    }
}
