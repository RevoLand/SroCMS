<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class User extends Authenticatable
{
    use Notifiable, MustVerifyEmail, CanResetPassword;

    public $timestamps = false;

    protected $connection = 'account';
    protected $table = 'TB_User';
    protected $primaryKey = 'JID';
    protected $guarded = [];

    public function getGravatarAttribute()
    {
        if (is_null($this->Email))
        {
            return;
        }

        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->Email));
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
        return $this->hasMany('App\LoginAttempt', 'username', 'StrUserID')->orderByDesc('updated_at');
    }

    public function updateEmail($newEmail)
    {
        $this->Email = $newEmail;
        $this->save();

        // TODO: E-posta doğrulamasının tekrar istenmesi?

        Alert::success('E-posta adresiniz başarıyla değiştirildi.'); // Doğrulama gerekiyor mu?

        return true;
    }

    public function updatePassword($newPassword)
    {
        $this->password = Hash::make($newPassword);
        $this->save();

        // TODO: Şifreyi değiştirmeden önce e-posta doğrulaması?
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->Email;
    }
}
