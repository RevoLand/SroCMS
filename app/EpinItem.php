<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpinItem extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function epin()
    {
        return $this->belongsTo(Epin::class);
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
