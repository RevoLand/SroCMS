<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefOptionalTeleport extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'Service' => $this->Service,
            'ID' => $this->ID,
            'ObjName128' => $this->ObjName128,
            'ZoneName128' => $this->ZoneName128,
            'RegionID' => $this->RegionID,
            'Pos_X' => $this->Pos_X,
            'Pos_Y' => $this->Pos_Y,
            'Pos_Z' => $this->Pos_Z,
            'WorldID' => $this->WorldID,
            'RegionIDGroup' => $this->RegionIDGroup,
            'MapPoint' => $this->MapPoint,
            'LevelMin' => $this->LevelMin,
            'LevelMax' => $this->LevelMax,
            'Param1' => $this->Param1,
            'Param1_Desc_128' => $this->Param1_Desc_128,
            'Param2' => $this->Param2,
            'Param2_Desc_128' => $this->Param2_Desc_128,
            'Param3' => $this->Param3,
            'Param3_Desc_128' => $this->Param3_Desc_128,
            'zone_name' => $this->zoneName ? $this->zoneName->name : $this->ZoneName128 ?? '',
        ];
    }
}
