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
        return $this->hasOne(Silk::class, 'JID')->withDefault(function ($silk)
        {
            $silk->silk_own = 0;
            $silk->silk_gift = 0;
            $silk->silk_point = 0;
            $silk->save();
        });
    }

    public function balance()
    {
        return $this->hasOne(UserBalance::class, 'user_id', 'JID')->withDefault(function ($balance)
        {
            $balance->balance = 0;
            $balance->balance_point = 0;
            $balance->save();
        });
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
        return $this->hasMany(LoginAttempt::class, 'username', 'StrUserID')->latest();
    }

    public function updateEmail($newEmail)
    {
        $this->update([
            'Email' => $newEmail,
            'email_verified_at' => null,
        ]);
    }

    public function updatePassword($newPassword)
    {
        $this->update([
            'password' => Hash::make($newPassword),
            'email_verified_at' => null,
        ]);
    }

    public function setReferrer($referrerUserId)
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
        return $this->hasMany(VoteLog::class, 'user_id');
    }

    public function voteLogsById($voteProviderId)
    {
        return $this->hasMany(VoteLog::class, 'user_id')->where('vote_provider_id', $voteProviderId);
    }

    public function addChestItem($itemCodeName, $data, $optLevel)
    {
        DB::connection('shard')->statement(
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
