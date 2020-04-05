<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VoteProviderIpsDataTable;
use App\Http\Controllers\Controller;
use App\VoteProviderIp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        request()->validate([
            'ip' => ['required', 'ip', 'unique:App\VoteProviderIp,ip'],
        ]);

        $ip = VoteProviderIp::create([
            'ip' => request('ip'),
        ]);

        return redirect()->route('admin.votes.providers.ips.edit', compact('ip'))->with('message', 'IP is successfully added.');
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
        request()->validate([
            'ip' => ['required', 'ip', Rule::unique('vote_provider_ips')->ignoreModel($ip)],
        ]);

        $ip->update(['ip' => request('ip')]);

        return redirect()->route('admin.votes.providers.ips.edit', compact('ip'))->with('message', 'IP is successfully updated.');
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

        if (request()->expectsJson())
        {
            return response()->json([
                'title' => 'Deleted!',
                'message' => 'Selected IP has been deleted as requested.',
                'type' => 'success',
            ]);
        }

        return redirect()->route('admin.votes.providers.ips.index')->with('message', 'Selected IP has been deleted.');
    }
}
