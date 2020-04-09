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
        $this->validateEpin();

        $code = (request('regenerate_code') == 1 || !request('code')) ? $this->generateCode() : request('code');

        $epin->update([
            'code' => $code,
            'type' => request('type'),
            'balance' => request('balance'),
            'creater_user_id' => auth()->user()->JID,
            'enabled' => request('enabled'),
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected E-Pin code is successfully updated',
            'icon' => 'success',
            'epin' => $epin,
        ]);
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

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected E-Pin is successfully deleted',
            'icon' => 'success',
        ]);
    }

    public function toggleEnabled(Epin $epin)
    {
        $epin->update([
            'enabled' => !$epin->enabled,
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected E-Pin status has been successfully updated.',
            'icon' => 'success',
        ]);
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
    public function store()
    {
        $this->validateEpin();

        $code = (request('regenerate_code') == 1 || !request('code')) ? $this->generateCode() : request('code');

        $epin = Epin::create([
            'code' => $code,
            'type' => request('type'),
            'balance' => request('balance'),
            'creater_user_id' => auth()->user()->JID,
            'enabled' => request('enabled'),
        ]);

        return response()->json([
            'title' => 'Created!',
            'message' => 'E-Pin is successfully created.<br/><a class="btn btn-falcon-success" href="' . route('admin.epins.edit', $epin) . '">Click here</a> to edit the created E-Pin code.',
            'icon' => 'success',
        ]);
    }

    private function validateEpin()
    {
        return request()->validate([
            'code' => ['nullable', 'string'],
            'type' => ['required', 'integer', Rule::in(config('constants.payment_types'))],
            'balance' => ['nullable', 'numeric', Rule::requiredIf(request('type') < 6)],
            'regenerate_code' => ['sometimes', 'boolean'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
