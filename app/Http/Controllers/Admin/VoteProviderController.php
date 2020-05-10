<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VoteProvidersDataTable;
use App\Http\Controllers\Controller;
use App\VoteProvider;
use Illuminate\Http\Request;
use Str;

class VoteProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VoteProvidersDataTable $dataTable)
    {
        return $dataTable->render('votes.providers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('votes.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateProvider();

        $callback_secret = (!request()->filled('callback_secret') || request('generate_callback_secret') == 1) ? $this->generateCallbackSecret() : request('callback_secret');

        $provider = VoteProvider::create([
            'name' => request('name'),
            'url' => request('url'),
            'url_user_name' => request('url_user_name'),
            'callback_secret' => $callback_secret,
            'callback_user_name' => request('callback_user_name'),
            'callback_success_name' => request('callback_success_name'),
            'minutes_between_votes' => request('minutes_between_votes'),
            'enabled' => request('enabled'),
        ]);

        return response()->json([
            'title' => 'Created!',
            'message' => 'Vote Provider has been successfully created.<br/><input type="text" readonly class="form-control bg-white" value="' . route('votes.callback_url', $provider->callback_secret) . '"><br />GET & POST methods are supported for the URL.',
            'icon' => 'success',
        ]);
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
    public function edit(VoteProvider $provider)
    {
        return view('admin.votes.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoteProvider $provider)
    {
        $this->validateProvider();

        $callback_secret = (!request()->filled('callback_secret') || request('generate_callback_secret') == 1) ? $this->generateCallbackSecret() : request('callback_secret');

        $provider->update([
            'name' => request('name'),
            'url' => request('url'),
            'url_user_name' => request('url_user_name'),
            'callback_secret' => $callback_secret,
            'callback_user_name' => request('callback_user_name'),
            'callback_success_name' => request('callback_success_name'),
            'minutes_between_votes' => request('minutes_between_votes'),
            'enabled' => request('enabled'),
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Vote Provider has been successfully updated.<br/><input type="text" readonly class="form-control bg-white" value="' . route('votes.callback_url', $provider->callback_secret) . '"><br />GET & POST methods are supported for the URL.',
            'icon' => 'success',
        ]);
    }

    public function getCallbackUrl(Request $request, VoteProvider $provider)
    {
        return response()->json([
            'title' => 'Callback URL for: ' . $provider->name,
            'message' => '<input type="text" readonly class="form-control bg-white" value="' . route('votes.callback_url', $provider->callback_secret) . '"><br />GET & POST methods are supported for the URL.',
            'icon' => 'info',
        ]);
    }

    public function toggleEnabled(Request $request, VoteProvider $provider)
    {
        $provider->update([
            'enabled' => !$provider->enabled,
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Enabled state has been successfully updated for selected vote provider.',
            'icon' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoteProvider $provider)
    {
        $provider->delete();

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected Vote Provider has been successfully deleted.',
            'icon' => 'success',
        ]);
    }

    private function validateProvider()
    {
        return request()->validate([
            'name' => ['required', 'string'],
            'url' => ['required', 'string'],
            'url_user_name' => ['required', 'string'],
            'callback_secret' => ['nullable', 'sometimes', 'string'],
            'generate_callback_secret' => ['sometimes', 'boolean'],
            'callback_user_name' => ['required', 'string'],
            'callback_success_name' => ['nullable', 'sometimes', 'string'],
            'minutes_between_votes' => ['required', 'integer'],
            'enabled' => ['required', 'boolean'],
        ]);
    }

    private function generateCallbackSecret($length = 40): string
    {
        $randomString = Str::random($length);

        return VoteProvider::where('callback_secret', $randomString)->count() > 0 ? $this->generateVoteLogSecret($length) : $randomString;
    }
}
