<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetItemGroup extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefSetItemGroup';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function name()
    {
        return $this->hasOne(Name::class, 'key', 'NameStrID128');
    }

    public function getName()
    {
        return ($this->name) ? $this->name->name : $this->NameStrID128;
    }
}
