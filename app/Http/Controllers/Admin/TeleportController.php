<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObjCommon as ResourcesObjCommon;
use App\Http\Resources\RefTeleport as ResourcesRefTeleport;
use App\ObjCommon;
use App\RefTeleport;

class TeleportController extends Controller
{
    public function index()
    {
        $availableTeleportBuildings = ResourcesObjCommon::collection(ObjCommon::teleportUsable()->with('name')->orderBy('CodeName128')->get());
        $teleports = ResourcesRefTeleport::collection(RefTeleport::with(['zoneName', 'objCommon.name', 'ownedTeleports' => function ($query)
        {
            $query->with(['owner.zoneName', 'owner.objCommon.name', 'target.zoneName', 'target.objCommon.name'])->orderBy('OwnerTeleport');
        }, ])->orderBy('GenRegionID')->orderBy('CodeName128')->get());

        return view('teleports.index', compact('availableTeleportBuildings', 'teleports'));
    }

    public function update()
    {
        $validatedInputs = request()->validate([
            'ID' => ['sometimes', 'integer', 'exists:App\RefTeleport,ID'],
            'CodeName128' => ['required', 'alpha_dash'],
            'AssocRefObjCodeName128' => ['required', 'string'],
            'AssocRefObjID' => ['nullable', 'integer', 'exists:App\ObjCommon,ID'],
            'ZoneName128' => ['required', 'string'],
            'GenRegionID' => ['required', 'numeric'],
            'GenPos_X' => ['required', 'numeric'],
            'GenPos_Y' => ['required', 'numeric'],
            'GenPos_Z' => ['required', 'numeric'],
            'GenAreaRadius' => ['required', 'integer'],
            'GenWorldID' => ['required', 'integer'],
            'CanBeResurrectPos' => ['required', 'boolean'],
            'CanGotoResurrectPos' => ['required', 'boolean'],
            'Service' => ['required', 'boolean'],
            'BindInteractionMask' => ['required', 'integer'],
            'FixedService' => ['required', 'integer'],
        ]);

        $teleport = RefTeleport::find(request('ID'));

        if (!$teleport)
        {
            request()->validate(['CodeName128' => ['unique:App\RefTeleport,CodeName128']]);

            return $this->store($validatedInputs);
        }

        $teleport->update($validatedInputs);

        return response()->json(['message' => 'Selected Teleport Point is successfully updated.']);
    }

    public function destroy()
    {
        request()->validate([
            'id' => ['required', 'integer', 'exists:App\RefTeleport,ID'],
        ]);

        $teleport = RefTeleport::find(request('id'));

        $teleport->ownedTeleports()->delete();
        $teleport->targetedTeleports()->delete();

        $teleport->delete();

        return response()->json(['message' => 'Selected Teleport Point is successfully deleted from database.']);
    }

    private function store($validatedInputs)
    {
        return response()->json(['teleport' => new ResourcesRefTeleport(RefTeleport::where('ID', RefTeleport::create($validatedInputs)->ID)->with(['zoneName', 'objCommon.name'])->first()), 'message' => 'Teleport Point is successfully created.']);
    }
}
