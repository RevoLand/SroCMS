<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RefOptionalTeleport as ResourcesRefOptionalTeleport;
use App\RefOptionalTeleport;
use Illuminate\Validation\Rule;

class OptionalTeleportController extends Controller
{
    public function index()
    {
        $reversePoints = ResourcesRefOptionalTeleport::collection(RefOptionalTeleport::with('zoneName')->get());

        return view('teleports.reverse_points', compact('reversePoints'));
    }

    public function update()
    {
        $validatedParams = request()->validate([
            'ID' => ['sometimes', 'integer', 'exists:App\RefOptionalTeleport'],
            'ObjName128' => ['required', 'string'],
            'ZoneName128' => ['required', 'string'],
            'RegionID' => ['required', 'integer'],
            'Pos_X' => ['required', 'integer'],
            'Pos_Y' => ['required', 'integer'],
            'Pos_Z' => ['required', 'integer'],
            'WorldID' => ['required', 'integer'],
            'RegionIDGroup' => ['nullable', 'integer'],
            'MapPoint' => ['nullable', 'integer'],
            'LevelMin' => ['nullable', 'integer'],
            'LevelMax' => ['nullable', 'integer'],
            'Param1' => ['nullable', 'integer'],
            'Param2' => ['nullable', 'integer'],
            'Param3' => ['nullable', 'integer'],
            'Param1_Desc_128' => ['nullable', 'string', Rule::requiredIf(request()->filled('Param1') && request('Param1') != -1)],
            'Param2_Desc_128' => ['nullable', 'string', Rule::requiredIf(request()->filled('Param2') && request('Param2') != -1)],
            'Param3_Desc_128' => ['nullable', 'string', Rule::requiredIf(request()->filled('Param3') && request('Param3') != -1)],
            'Service' => ['required', 'boolean'],
        ]);

        $teleport = RefOptionalTeleport::find(request('ID'));

        if (!$teleport)
        {
            return $this->store($validatedParams);
        }

        $teleport->update($validatedParams);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected Reverse Point is successfully updated.',
            'icon' => 'success',
        ]);
    }

    public function destroy()
    {
        request()->validate([
            'id' => ['required', 'integer', 'exists:App\RefOptionalTeleport,ID'],
        ]);

        RefOptionalTeleport::find(request('id'))->delete();

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected Reverse Point is successfully deleted.',
            'icon' => 'success',
        ]);
    }

    private function store($validatedParams)
    {
        return response()->json([
            'title' => 'Created!',
            'message' => 'Reverse Point is successfully created.',
            'icon' => 'success',
            'reverse_point' => new ResourcesRefOptionalTeleport(RefOptionalTeleport::create($validatedParams)->load('zoneName')),
        ]);
    }
}
