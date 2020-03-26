<?php

namespace App;

use App\Scopes\NoLockScope;
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
        return $this->hasOne(ObjItem::class, 'ID', 'Link');
    }

    public function objChar()
    {
        return $this->hasOne(ObjChar::class, 'ID', 'Link');
    }

    public function name()
    {
        return $this->hasOne(Name::class, 'key', 'NameStrID128');
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

    public function scopeMonster($query)
    {
        return $query->where('TypeID1', 1)->where('TypeID2', 2)->where('TypeID3', 1);
    }

    public function scopeNpc($query)
    {
        return $query->where('TypeID1', 1)->where('TypeID2', 2)->where('TypeID3', 2);
    }

    public function scopeItem($query)
    {
        return $query->where('TypeID1', 3);
    }

    public function scopeStructure($query)
    {
        return $query->where('TypeID1', 4);
    }

    public function scopeTeleportUsable($query)
    {
        return $query->where('TypeID1', 1)
            ->where('TypeID2', 2)
            ->where('TypeID3', 2)
            ->orWhere('TypeID1', 4);
    }

    public function scopeIgnoreDummy($query)
    {
        return $query->where('ID', '!=', 0);
    }

    protected static function booted()
    {
        static::addGlobalScope(new NoLockScope());
    }
}
