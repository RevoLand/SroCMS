<?php

namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, CanResetPassword, HasRoles;
    const CREATED_AT = 'regtime';
    const UPDATED_AT = null;

    protected $connection = 'account';
    protected $table = 'TB_User';
    protected $primaryKey = 'JID';
    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getGravatarAttribute()
    {
        if (is_null($this->Email))
        {
            return;
        }

        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->Email));
    }

    public function getName()
    {
        return $this->Name ?? $this->StrUserID;
    }

    public function silk()
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

    public function loginAttempts()
    {
        return $this->hasMany('App\LoginAttempt', 'username', 'StrUserID')->latest();
    }

    public function updateEmail($newEmail)
    {
        $this->Email = $newEmail;
        $this->email_verified_at = null;
        $this->save();
    }

    public function updatePassword($newPassword)
    {
        $this->password = Hash::make($newPassword);
        $this->save();
    }

    public function getEmailForPasswordReset()
    {
        return $this->Email;
    }

    public function routeNotificationForMail()
    {
        return $this->Email;
    }

    public function characters()
    {
        return $this->hasManyThrough('App\Character', 'App\ShardUser', 'UserJID', 'CharID', 'JID', 'CharID');
    }

    public function voteLogs()
    {
        return $this->hasMany('App\VoteLog', 'user_id', 'JID');
    }

    public function voteLogsById($voteProviderId)
    {
        return $this->hasMany('App\VoteLog', 'user_id', 'JID')->where('vote_provider_id', $voteProviderId);
    }

    public function lastVoteLog($voteProviderId)
    {
        return $this->hasOne('App\VoteLog', 'user_id', 'JID')->where('vote_provider_id', $voteProviderId)->latest('updated_at')->first();
    }
}
