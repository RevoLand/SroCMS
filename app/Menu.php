<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Page::class, 'target_page_id', 'id');
    }
}
