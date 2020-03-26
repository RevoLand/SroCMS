<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UniqueLog extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'account';

    public function user()
    {
        return $this->belongsTo(User::class, 'UserJID', 'JID');
    }

    public function character()
    {
        return $this->belongsTo(Character::class, 'CharacterID', 'CharID');
    }

    public function unique()
    {
        return $this->belongsTo(ObjCommon::class, 'uniquecodename', 'CodeName128');
    }
}
