<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey = 'ID64';
    protected $table = '_Items';
    protected $guarded = [];

    public function objCommon()
    {
        return $this->hasOne(ObjCommon::class, 'ID', 'RefItemID');
    }

    public function getTypeAttribute()
    {
        switch ($this->objCommon->TypeID3)
        {
            case 6:
                return 'weapon';
            break;
            case 4:
                return 'shield';
            break;
            case 1:
            case 2:
            case 3:
            case 9:
            case 10:
            case 11:
            case 7: // Trade items
                return 'equipment';
            break;
            case 5:
            case 12:
                return 'accessory';
            break;
            default:
                dd($this->ID64);
            break;
        }
    }

    public function getStatsAttribute(): object
    {
        $varianceTemp = $this->Variance;
        $whiteStats = [];
        $currentPosition = 0;
        while ($currentPosition < count(config('constants.item.white_stats.param_names.' . $this->type)))
        {
            $stat = $varianceTemp & 0x1F;
            $statPerc = $stat * 100 / 31;
            $whiteStats += [
                config('constants.item.white_stats.param_names.' . $this->type . '.' . $currentPosition) => ($stat <= 0) ? 0 : $statPerc,
            ];
            $varianceTemp >>= 5;
            ++$currentPosition;
        }

        return (object) $whiteStats;
    }

    public function getPhysicalMinDamageAttribute()
    {
        return intval($this->objCommon->objItem->PAttackMin_L + ($this->OptLevel * $this->objCommon->objItem->PAttackInc) + (($this->objCommon->objItem->PAttackMin_U - $this->objCommon->objItem->PAttackMin_L) * $this->stats->PhyAttack / 100));
    }

    public function getPhysicalMaxDamageAttribute()
    {
        return intval($this->objCommon->objItem->PAttackMax_L + ($this->OptLevel * $this->objCommon->objItem->PAttackInc) + (($this->objCommon->objItem->PAttackMax_U - $this->objCommon->objItem->PAttackMax_L) * $this->stats->PhyAttack / 100));
    }

    public function getMagicalMinDamageAttribute()
    {
        return intval($this->objCommon->objItem->MAttackMin_L + ($this->OptLevel * $this->objCommon->objItem->MAttackInc) + (($this->objCommon->objItem->MAttackMin_U - $this->objCommon->objItem->MAttackMin_L) * $this->stats->MagAttack / 100));
    }

    public function getMagicalMaxDamageAttribute()
    {
        return intval($this->objCommon->objItem->MAttackMax_L + ($this->OptLevel * $this->objCommon->objItem->MAttackInc) + (($this->objCommon->objItem->MAttackMax_U - $this->objCommon->objItem->MAttackMax_L) * $this->stats->MagAttack / 100));
    }

    public function getDurabilityAttribute()
    {
        return intval($this->objCommon->objItem->Dur_L + (($this->objCommon->objItem->Dur_U - $this->objCommon->objItem->Dur_L) * $this->stats->Durability / 100));
    }

    public function getRangeAttribute()
    {
        return number_format($this->objCommon->objItem->Range / 10, 1);
    }

    public function getAttackRateAttribute()
    {
        return intval($this->objCommon->objItem->HR_L + (($this->objCommon->objItem->HR_U - $this->objCommon->objItem->HR_L) * $this->stats->HitRatio / 100));
    }

    public function getCriticalAttribute()
    {
        return intval($this->objCommon->objItem->CHR_L + (($this->objCommon->objItem->CHR_U - $this->objCommon->objItem->CHR_L) * $this->stats->CriticalRatio / 100));
    }

    public function getPhysicalMinReinforcementAttribute()
    {
        return number_format(round($this->objCommon->objItem->PAStrMin_L + (($this->objCommon->objItem->PAStrMin_U - $this->objCommon->objItem->PAStrMin_L) * $this->stats->PhyReinforce / 100)) / 10, 1);
    }

    public function getPhysicalMaxReinforcementAttribute()
    {
        return number_format(round($this->objCommon->objItem->PAStrMax_L + (($this->objCommon->objItem->PAStrMax_U - $this->objCommon->objItem->PAStrMax_L) * $this->stats->PhyReinforce / 100)) / 10, 1);
    }

    public function getMagicalMinReinforcementAttribute()
    {
        return number_format(round($this->objCommon->objItem->MAInt_Min_L + (($this->objCommon->objItem->MAInt_Min_U - $this->objCommon->objItem->MAInt_Min_L) * $this->stats->MagReinforce / 100)) / 10, 1);
    }

    public function getMagicalMaxReinforcementAttribute()
    {
        return number_format(round($this->objCommon->objItem->MAInt_Max_L + (($this->objCommon->objItem->MAInt_Max_U - $this->objCommon->objItem->MAInt_Max_L) * $this->stats->MagReinforce / 100)) / 10, 1);
    }
}
