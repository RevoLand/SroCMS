<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefRegion extends JsonResource
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
            'wRegionID' => $this->wRegionID,
            'ContinentName' => $this->ContinentName,
            'AreaName' => $this->AreaName,
        ];
    }
}
