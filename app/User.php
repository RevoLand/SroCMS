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
        return $this->hasOne('App\Silk', 'JID', 'JID')->withDefault(function ($silk)
        {
            $silk->JID = $this->JID;
            $silk->silk_own = 0;
            $silk->silk_gift = 0;
            $silk->silk_point = 0;
            $silk->save();
        });
    }

    public function LoginAttempts()
    {
        return $this->hasMany('App\LoginAttempt', 'username', 'StrUserID')->orderByDesc('updated_at');
    }
}
