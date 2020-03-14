<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ObjCommon extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefObjCommon';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function objItem()
    {
        return $this->hasOne(ObjItem::class, 'ID', 'Link')->nolock();
    }

    public function objChar()
    {
        return $this->hasOne(ObjChar::class, 'ID', 'Link')->nolock();
    }

    public function name()
    {
        return $this->hasOne(Name::class, 'key', 'NameStrID128');
    }

    public function scopeNoLock($query)
    {
        return $query->lock('WITH(NOLOCK)');
    }

    public function getName()
    {
        return ($this->name) ? $this->name->name : $this->CodeName128;
    }

    public function getImageAttribute()
    {
        if ($this->AssocFileIcon128 == 'xxx')
        {
            return theme_url('img/silkroad/no_item.png');
        }

        return theme_url('img/silkroad/' . Str::lower(Str::replaceFirst('.ddj', '.png', $this->AssocFileIcon128)));
    }

    public function getSortOfItemAttribute()
    {
        return config('constants.item.typeid.' . $this->TypeID3 . '.name') ?: '[DEBUG] Bulunamadı: ' . $this->TypeID3;
    }

    public function getMountingPartAttribute()
    {
        return config('constants.item.typeid.' . $this->TypeID3 . '.' . $this->TypeID4) ?: '[DEBUG] Bulunamadı: ' . $this->TypeID4;
    }
}
