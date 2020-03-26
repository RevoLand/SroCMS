<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObjCommon extends JsonResource
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
        /* Can be populated as much as needed, no need to take the whole database at this point. */
        return [
            'Service' => $this->Service,
            'ID' => $this->ID,
            'CodeName128' => $this->CodeName128,
            'AssocFileObj128' => $this->AssocFileObj128,
            'name' => ($this->name) ? $this->name->name : $this->CodeName128,
        ];
    }
}
