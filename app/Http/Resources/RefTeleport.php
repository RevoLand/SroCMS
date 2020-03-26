<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefTeleport extends JsonResource
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
            'CodeName128' => $this->CodeName128,
            'AssocRefObjCodeName128' => $this->AssocRefObjCodeName128,
            'AssocRefObjID' => $this->AssocRefObjID,
            'ZoneName128' => $this->ZoneName128,
            'GenRegionID' => $this->GenRegionID,
            'GenPos_X' => $this->GenPos_X,
            'GenPos_Y' => $this->GenPos_Y,
            'GenPos_Z' => $this->GenPos_Z,
            'GenAreaRadius' => $this->GenAreaRadius,
            'CanBeResurrectPos' => $this->CanBeResurrectPos,
            'CanGotoResurrectPos' => $this->CanGotoResurrectPos,
            'GenWorldID' => $this->GenWorldID,
            'BindInteractionMask' => $this->BindInteractionMask,
            'FixedService' => $this->FixedService,
            'zone_name' => $this->zoneName ? $this->zoneName->name : $this->ZoneName128,
            'obj_name' => $this->objCommon ? $this->objCommon->getName() : $this->AssocRefObjCodeName128,
        ];
    }
}
