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
}
