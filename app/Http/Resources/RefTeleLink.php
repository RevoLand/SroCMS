<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefTeleLink extends JsonResource
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
            'OwnerTeleport' => $this->OwnerTeleport,
            'TargetTeleport' => $this->TargetTeleport,
            'Fee' => $this->Fee,
            'RestrictBindMethod' => $this->RestrictBindMethod,
            'RunTimeTeleportMethod' => $this->RunTimeTeleportMethod,
            'CheckResult' => $this->CheckResult,
            'Restrict1' => $this->Restrict1,
            'Data1_1' => $this->Data1_1,
            'Data1_2' => $this->Data1_2,
            'Restrict2' => $this->Restrict2,
            'Data2_1' => $this->Data2_1,
            'Data2_2' => $this->Data2_2,
            'Restrict3' => $this->Restrict3,
            'Data3_1' => $this->Data3_1,
            'Data3_2' => $this->Data3_2,
            'Restrict4' => $this->Restrict4,
            'Data4_1' => $this->Data4_1,
            'Data4_2' => $this->Data4_2,
            'Restrict5' => $this->Restrict5,
            'Data5_1' => $this->Data5_1,
            'Data5_2' => $this->Data5_2,
            'ID' => $this->ID,
            'owner_zone_name' => $this->owner->zoneName ? $this->owner->zoneName->name : $this->owner->ZoneName128 ?? '',
            'owner_obj_name' => $this->owner->objCommon ? $this->owner->objCommon->getName() : $this->owner->AssocRefObjCodeName128 ?? '',
            'target_zone_name' => $this->target->zoneName ? $this->target->zoneName->name : $this->target->ZoneName128 ?? '',
            'target_obj_name' => $this->target->objCommon ? $this->target->objCommon->getName() : $this->target->AssocRefObjCodeName128 ?? '',
        ];
    }
}
