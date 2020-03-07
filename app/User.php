<?php

namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        return $this->hasOne(Silk::class, 'JID', 'JID')->withDefault(function ($default)
        {
            $default->silk_own = 0;
            $default->silk_gift = 0;
            $default->silk_point = 0;
            $default->save();
        });
    }

    public function balance()
    {
        return $this->hasOne(UserBalance::class, 'user_id', 'JID')->withDefault(function ($default)
        {
            $default->balance = 0;
            $default->balance_point = 0;
            $default->save();
        });
    }

    public function orders()
    {
        return $this->hasMany(ItemMallOrder::class, 'user_id', 'JID');
    }

    public function referrer()
    {
        return $this->hasOne(Referral::class, 'user_id', 'JID');
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_user_id', 'JID');
    }

    public function silkBuyList()
    {
        return $this->hasMany(SilkBuyList::class, 'UserJID', 'JID');
    }

    public function silkChangeByWeb()
    {
        return $this->hasMany(SilkChangeByWeb::class, 'JID');
    }

    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class, 'username', 'StrUserID');
    }

    public function updateEmail(string $newEmail)
    {
        $this->update([
            'Email' => $newEmail,
            'email_verified_at' => null,
        ]);
    }

    public function updatePassword(string $newPassword)
    {
        $this->update([
            'password' => Hash::make($newPassword),
            'email_verified_at' => null,
        ]);
    }

    public function setReferrer(int $referrerUserId)
    {
        $this->referrer()->create([
            'referrer_user_id' => $referrerUserId,
        ]);
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
        return $this->hasManyThrough(Character::class, ShardUser::class, 'UserJID', 'CharID', 'JID', 'CharID');
    }

    public function voteLogs()
    {
        return $this->hasMany(VoteLog::class, 'user_id', 'JID');
    }

    public function voteLogsByProviderId(int $voteProviderId)
    {
        return $this->voteLogs()->voteProvider($voteProviderId);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'JID');
    }

    public function addChestItem(string $itemCodeName, int $data, int $optLevel): bool
    {
        return DB::connection('shard')->statement(
            'exec _ADD_ITEM_EXTERN_CHEST @account_name = ?, @codename = ?, @data = ?, @opt_level = ?',
            [
                $this->StrUserID,
                $itemCodeName,
                $data,
                $optLevel,
            ]
        );
    }
}
