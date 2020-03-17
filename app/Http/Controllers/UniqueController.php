<?php

namespace App\Http\Controllers;

use App\UniqueLog;

class UniqueController extends Controller
{
    public function index()
    {
        $uniques = UniqueLog::with(['user', 'character', 'unique.name'])->latest()->take(50)->get();

        return view('uniques.index', compact('uniques'));
    }
}
