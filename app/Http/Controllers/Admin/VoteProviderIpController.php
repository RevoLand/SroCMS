<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VoteProviderIpsDataTable;
use App\Http\Controllers\Controller;
use App\VoteProviderIp;
use Illuminate\Http\Request;

class VoteProviderIpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VoteProviderIpsDataTable $dataTable)
    {
        return $dataTable->render('votes.providers.ips.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('votes.providers.ips.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateIp();

        $ip = VoteProviderIp::create([
            'ip' => request('ip'),
        ]);

        return redirect()->route('admin.votes.providers.ips.edit', compact('ip'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(VoteProviderIp $ip)
    {
        return view('votes.providers.ips.edit', compact('ip'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoteProviderIp $ip)
    {
        $this->validateIp();

        $ip->update(['ip' => request('ip')]);

        return redirect()->route('admin.votes.providers.ips.edit', compact('ip'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoteProviderIp $ip)
    {
        $ip->delete();

        return redirect()->route('admin.votes.providers.ips.index')->with('message', 'Selected IP has been deleted.');
    }

    public function destroyAjax(VoteProviderIp $ip)
    {
        $ip->delete();

        return response()->json(['message' => 'Selected IP has been deleted as requested.']);
    }

    private function validateIp()
    {
        return request()->validate([
            'ip' => ['required', 'ip', 'unique:App\VoteProviderIp,ip'],
        ]);
    }
}
