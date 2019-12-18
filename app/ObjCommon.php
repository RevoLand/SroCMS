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
        return $this->hasOne('App\ObjItem', 'ID', 'Link');
    }

    public function objChar()
    {
        return $this->hasOne('App\ObjChar', 'ID', 'Link');
    }

    public function getImageAttribute()
    {
        if ($this->AssocFileIcon128 == 'xxx')
        {
            return theme_url('images/silkroad/no_item.png');
        }

        return theme_url('images/silkroad/' . Str::lower(Str::replaceFirst('.ddj', '.png', $this->AssocFileIcon128)));
    }
}
