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

    public function bindingOptionWithItem()
    {
        // TODO: Make constants from types?
        // 2 = adv
        return $this->hasOne(BindingOptionWithItem::class, 'nItemDBID', 'ID64')->type('2');
    }

    public function getNameAttribute()
    {
        return ($this->objCommon->name) ? $this->objCommon->name->name : $this->objCommon->CodeName128;
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
                return 'equipment';
            case 7: // Trade items
                return 'trade';
            break;
            case 5:
            case 12:
                return 'accessory';
            break;
            case 13: // Avatars
                return 'avatar';
            break;
            case 14: // Devil spirit
                return 'devilspirit';
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

    public function getPhysicalDefensePowerAttribute()
    {
        return number_format($this->objCommon->objItem->PD_L + ($this->OptLevel * $this->objCommon->objItem->PDInc) + (($this->objCommon->objItem->PD_U - $this->objCommon->objItem->PD_L) * $this->stats->PhyDefense / 100), 1);
    }

    public function getMagicalDefensePowerAttribute()
    {
        return number_format($this->objCommon->objItem->MD_L + ($this->OptLevel * $this->objCommon->objItem->MDInc) + (($this->objCommon->objItem->MD_U - $this->objCommon->objItem->MD_L) * $this->stats->PhyDefense / 100), 1);
    }

    public function getParryRateAttribute()
    {
        return intval($this->objCommon->objItem->ER_L + ($this->OptLevel * $this->objCommon->objItem->ERInc) + (($this->objCommon->objItem->ER_U - $this->objCommon->objItem->ER_L) * $this->stats->ParryRatio / 100));
    }

    public function getBlockingRateAttribute()
    {
        return intval($this->objCommon->objItem->BR_L + ($this->OptLevel * $this->objCommon->objItem->BRInc) + (($this->objCommon->objItem->BR_U - $this->objCommon->objItem->BR_L) * $this->stats->BlockRatio / 100));
    }

    public function getPhysicalReinforcementAttribute()
    {
        return number_format(round($this->objCommon->objItem->PDStr_L + (($this->objCommon->objItem->PDStr_U - $this->objCommon->objItem->PDStr_L) * $this->stats->PhyReinforce / 100)) / 10, 1);
    }

    public function getMagicalReinforcementAttribute()
    {
        return number_format(round($this->objCommon->objItem->MDInt_L + (($this->objCommon->objItem->MDInt_U - $this->objCommon->objItem->MDInt_L) * $this->stats->MagReinforce / 100)) / 10, 1);
    }

    // accessories
    public function getPhysicalAbsorptionAttribute()
    {
        return number_format($this->objCommon->objItem->PAR_L + ($this->OptLevel * $this->objCommon->objItem->PARInc) + (($this->objCommon->objItem->PAR_U - $this->objCommon->objItem->PAR_L) * $this->stats->PhyAbsorption / 100), 1);
    }

    public function getMagicalAbsorptionAttribute()
    {
        return number_format($this->objCommon->objItem->MAR_L + ($this->OptLevel * $this->objCommon->objItem->MARInc) + (($this->objCommon->objItem->MAR_U - $this->objCommon->objItem->MAR_L) * $this->stats->MagAbsorption / 100), 1);
    }

    public function getMagicParamsAttribute()
    {
        if (!$this->MagParamNum)
        {
            return [];
        }

        $magicParamValues = [];

        for ($paramIndex = 1; $paramIndex <= $this->MagParamNum; ++$paramIndex)
        {
            $magicParamValues[] = $this->parseMagicParamValue($this->{'MagParam' . $paramIndex});
        }

        return (object) $magicParamValues;
    }

    private function parseMagicParamValue($magicParam): object
    {
        $magicParamInfo = [
            'magicOpt' => MagicOpt::find($magicParam & 0xFFF),
            'value' => ($magicParam >> 32) & 0xFF,
        ];

        $magicParamInfo += [
            'name' => config('constants.item.magic_attributes.' . $magicParamInfo['magicOpt']->MOptName128),
            'percentage' => intval(($magicParamInfo['value'] / $magicParamInfo['magicOpt']->stats->maxValue) * 100),
        ];

        // 'magicOpt' => MagicOpt::where('MOptName128', MagicOpt::find($magicParam & 0xFFF)->MOptName128)->where('MLevel', '<=', $this->objCommon->objItem->degree)->enabled()->orderByDesc('MLevel')->first(),

        return (object) $magicParamInfo;
    }
}
