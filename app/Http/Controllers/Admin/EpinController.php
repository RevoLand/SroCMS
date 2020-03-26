<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EpinsDataTable;
use App\Epin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Str;

class EpinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EpinsDataTable $dataTable)
    {
        return $dataTable->render('epins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('epins.create');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Epin $epin)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Epin $epin)
    {
        $epin->load('items');

        return view('epins.edit', compact('epin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Epin $epin)
    {
        /*
            "code" => "ALI-J4ZG-GV57-J02R-NR0T-MUSTI"
            "type" => "6"
            "balance" => null
            "enabled" => "1"
        */
        $this->validateEpin();

        $code = (request()->has('generate-code') || !request('code')) ? $this->generateCode() : request('code');

        $epin->update([
            'code' => $code,
            'type' => request('type'),
            'balance' => request('balance'),
            'creater_user_id' => auth()->user()->JID,
            'enabled' => request('enabled'),
        ]);

        return redirect()->route('admin.epins.edit', $epin)->with('message', 'E-Pin is successfully created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Epin $epin)
    {
        $epin->delete();

        if (request()->expectsJson())
        {
            return response()->json(['message' => 'Select E-Pin is successfully deleted.']);
        }

        return redirect()->route('admin.epins.index')->with('message', 'Selected E-Pin is successfully deleted.');
    }

    public function toggleEnabled(Epin $epin)
    {
        $epin->update([
            'enabled' => !$epin->enabled,
        ]);

        return response()->json(['message' => 'E-Pin status updated.']);
    }

    public function generateCode()
    {
        $mask = setting('epin.code.mask', '****-****-****-****');
        $length = substr_count($mask, '*');
        $code = setting('epin.code.prefix', '');
        $characters = collect(str_split(setting('epin.code.allowed_characters', 'ABCDEFGHJKLMNOPQRSTUVWXYZ234567890')));

        for ($i = 0; $i < $length; ++$i)
        {
            $mask = Str::replaceFirst('*', $characters->random(1)->first(), $mask);
        }

        $code .= $mask;
        $code .= setting('epin.code.suffix', '');

        if (Epin::where('code', $code)->count() !== 0)
        {
            return $this->generateCode();
        }

        return $code;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    private function store()
    {
        $this->validateEpin();

        $code = (request()->has('generate-code') || !request('code')) ? $this->generateCode() : request('code');

        $epin = Epin::create([
            'code' => $code,
            'type' => request('type'),
            'balance' => request('balance'),
            'creater_user_id' => auth()->user()->JID,
            'enabled' => request('enabled'),
        ]);

        return redirect()->route('admin.epins.edit', $epin)->with('message', 'E-Pin is successfully created.');
    }

    private function validateEpin()
    {
        return request()->validate([
            'code' => ['nullable', 'string'],
            'type' => ['required', 'integer', Rule::in(config('constants.payment_types'))],
            'balance' => ['nullable', 'numeric', Rule::requiredIf(request('type') < 6)],
            'generate-code' => ['sometimes', 'boolean'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
