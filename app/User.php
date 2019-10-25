<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'account';
    protected $table = 'TB_User';
    protected $guarded = [];
    protected $primaryKey = 'JID';
    public $timestamps = false;

    public function getGravatarAttribute()
    {
        if ($this->Email == "")
        {
            return;
        }

        return "https://www.gravatar.com/avatar/" . md5( strtolower( $this->Email ) );
    }
}
