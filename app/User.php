<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'account';
    protected $table = 'TB_User';
    protected $primaryKey = 'JID';
    protected $guarded = [];
    public $timestamps = false;

    public function getGravatarAttribute()
    {
        if ($this->Email == "")
        {
            return;
        }

        return "https://www.gravatar.com/avatar/" . md5( strtolower( $this->Email ) );
    }

    public function Silk()
    {
        return $this->hasOne('App\Silk', 'JID', 'JID');
    }
}
