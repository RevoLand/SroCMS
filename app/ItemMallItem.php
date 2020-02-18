<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMallItem extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function objCommon()
    {
        return $this->belongsTo(ObjCommon::class, 'codename', 'CodeName128');
    }

    public function getName()
    {
        return $this->name ?? ($this->objCommon->name ? $this->objCommon->name->name : $this->codename);
    }
}
