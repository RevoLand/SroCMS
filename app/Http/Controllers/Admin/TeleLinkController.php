<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RefTeleLink as ResourcesRefTeleLink;
use App\RefTeleLink;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeleLinkController extends Controller
{
    public function update()
    {
        $validatedInputs = request()->validate([
            'ID' => ['sometimes', 'integer', 'exists:App\RefTeleLink,ID'],
            'OwnerTeleport' => ['required', 'integer', 'exists:App\RefTeleport,ID'],
            'TargetTeleport' => ['required', 'integer', 'exists:App\RefTeleport,ID'],
            'Fee' => ['required', 'integer'],
            'RestrictBindMethod' => ['required', 'integer'],
            'RunTimeTeleportMethod' => ['required', 'integer'],
            'CheckResult' => ['required', 'integer'],
            'Restrict1' => ['required', 'integer'],
            'Restrict2' => ['required', 'integer'],
            'Restrict3' => ['required', 'integer'],
            'Restrict4' => ['required', 'integer'],
            'Restrict5' => ['required', 'integer'],
            'Data1_1' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict1 != 0)],
            'Data1_2' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict1 != 0)],
            'Data2_1' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict2 != 0)],
            'Data2_2' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict2 != 0)],
            'Data3_1' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict3 != 0)],
            'Data3_2' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict3 != 0)],
            'Data4_1' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict4 != 0)],
            'Data4_2' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict4 != 0)],
            'Data5_1' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict5 != 0)],
            'Data5_2' => ['nullable', 'integer', Rule::requiredIf(request()->Restrict5 != 0)],
            'Service' => ['required', 'boolean'],
        ]);

        $teleportLink = RefTeleLink::find(request('ID'));

        if (!$teleportLink)
        {
            return $this->store($validatedInputs);
        }

        $teleportLink->update($validatedInputs);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected Teleport Link is successfully updated.',
            'icon' => 'success',
        ]);
    }

    public function destroy()
    {
        request()->validate([
            'id' => ['required', 'integer', 'exists:App\RefTeleLink,ID'],
        ]);

        RefTeleLink::find(request('id'))->delete();

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected Teleport Link is successfully deleted.',
            'icon' => 'success',
        ]);
    }

    private function store($validatedInputs)
    {
        return response()->json([
            'title' => 'Created!',
            'message' => 'Teleport Link has been successfully created.',
            'icon' => 'success',
            'teleport_link' => new ResourcesRefTeleLink(RefTeleLink::create($validatedInputs)->load(['owner.zoneName', 'owner.objCommon.name', 'target.zoneName', 'target.objCommon.name'])),
        ]);
    }
}
