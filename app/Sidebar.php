<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function getContent()
    {
        switch ($this->template)
        {
            default:
                return $this->content;
            break;
            case '1':
                return view('sidebar.user');
            break;
        }
    }
}
