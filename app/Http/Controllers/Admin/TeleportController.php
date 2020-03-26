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
        $teleports = ResourcesRefTeleport::collection(RefTeleport::with(['zoneName', 'objCommon.name'])->orderBy('GenRegionID')->get());
        $availableTeleportBuildings = ResourcesObjCommon::collection(ObjCommon::teleportUsable()->with('name')->orderBy('CodeName128')->get());

        return view('teleports.index', compact('teleports', 'availableTeleportBuildings'));
    }

    public function updatePoint()
    {
        $validatedInputs = request()->validate([
            'Service' => ['required', 'boolean'],
            'ID' => ['sometimes', 'integer', 'exists:App\RefTeleport,ID'],
            'CodeName128' => ['required', 'alpha_dash'],
            'AssocRefObjCodeName128' => ['required', 'string', 'exists:App\ObjCommon,CodeName128'],
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
            'BindInteractionMask' => ['required', 'integer'],
            'FixedService' => ['required', 'integer'],
        ]);

        $teleport = RefTeleport::find(request('ID'));

        if (!$teleport)
        {
            return $this->storePoint($validatedInputs);
        }

        $teleport->update($validatedInputs);

        return response()->json(['message' => 'Selected Teleport Point is successfully updated.']);
    }

    public function destroyPoint()
    {
        request()->validate([
            'id' => ['required', 'integer', 'exists:App\RefTeleport,ID'],
        ]);

        $teleport = RefTeleport::find(request('id'));
        $teleport->delete();

        // TODO: Delete linked teleports
        // $teleport->linkedTeleports()->destroy()?

        return response()->json(['message' => 'Selected Teleport Point is successfully deleted from database.']);
    }

    private function storePoint($validatedInputs)
    {
        $teleport = RefTeleport::create($validatedInputs);

        return response()->json(['teleport' => $teleport, 'message' => 'Teleport Point is successfully created.']);
    }
}
