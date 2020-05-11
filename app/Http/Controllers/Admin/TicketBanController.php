<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TicketBansDataTable;
use App\Http\Controllers\Controller;
use App\TicketBan;
use Illuminate\Http\Request;

class TicketBanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TicketBansDataTable $dataTable)
    {
        return $dataTable->render('ticketbans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'user_id' => ['required', 'integer', 'exists:App\User,JID'],
            'reason' => ['nullable', 'string', 'max:500'],
            'ban_start' => ['required', 'date'],
            'ban_end' => ['required', 'date'],
        ]);

        $ticketBan = TicketBan::create([
            'user_id' => $validated['user_id'],
            'assigner_user_id' => auth()->user()->JID,
            'reason' => request('reason'),
            'ban_start' => $validated['ban_start'],
            'ban_end' => $validated['ban_end'],
        ]);

        $ticketBan->load('assigner');

        return response()->json([
            'title' => 'Success!',
            'message' => 'New Ticket Ban has been successfully assigned to the selected user.',
            'icon' => 'success',
            'new_ticket_ban' => $ticketBan,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TicketBan $ticketban)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketBan $ticketban)
    {
        return view('ticketbans.edit', compact('ticketban'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketBan $ticketban)
    {
        $validated = request()->validate([
            'reason' => ['nullable', 'string', 'max:500'],
            'ban_start' => ['required', 'date'],
            'ban_end' => ['required', 'date'],
        ]);

        $validated['assigner_user_id'] = auth()->user()->JID;

        $ticketban->update($validated);
        $ticketban->load('assigner');

        return response()->json([
            'title' => 'Success!',
            'message' => 'Ticket Ban has been successfully updated.',
            'icon' => 'success',
            'updated_ticket_ban' => $ticketban,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function cancel(Request $request, TicketBan $ticketban)
    {
        if (!$ticketban->active)
        {
            return response()->json([
                'title' => 'Error!',
                'message' => 'Ticket Ban has been already cancelled!',
                'icon' => 'error',
                'ban_cancelled_at' => $ticketban->ban_cancelled_at,
            ]);
        }

        $ticketban->update([
            'ban_cancelled_at' => now(),
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'Ticket Ban has been successfully updated.',
            'icon' => 'success',
            'ban_cancelled_at' => $ticketban->ban_cancelled_at,
        ]);
    }
}
