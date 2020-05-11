<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TicketsDataTable;
use App\Http\Controllers\Controller;
use App\Notifications\TicketAssigned;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TicketsDataTable $dataTable)
    {
        return $dataTable->render('tickets.index');
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
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['category', 'messages' => function ($query)
        {
            $query->oldest()->with(['user', 'attachments']);
        }, 'order', 'user' => function ($userq)
        {
            $userq->with(['ticketBans' => function ($ticketq)
            {
                $ticketq->latest('ban_end');
            }, 'ticketBans.assigner', ]);
        }, 'assignedUser', ]);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

    public function update_status(Ticket $ticket)
    {
        request()->validate([
            'status' => ['required', 'integer', Rule::in(config('constants.ticket_system.status_array'))],
        ]);

        $ticket->update([
            'status' => request('status'),
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Ticket Status is successfully updated.',
            'icon' => 'success',
        ]);
    }

    public function update_priority(Ticket $ticket)
    {
        request()->validate([
            'priority' => ['required', 'integer', Rule::in(config('constants.ticket_system.priority_array'))],
        ]);

        $ticket->update([
            'priority' => request('priority'),
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Ticket Priority is successfully updated.',
            'icon' => 'success',
        ]);
    }

    public function update_assigned_user(Ticket $ticket)
    {
        request()->validate([
            'user_id' => ['required', 'integer', 'exists:App\User,JID'],
        ]);

        $ticket->update([
            'assigned_user_id' => request('user_id'),
        ]);

        $ticket->assignedUser->notify(new TicketAssigned($ticket, auth()->user()));

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Assigned User is successfully updated.',
            'icon' => 'success',
            'assigned_user' => $ticket->assignedUser,
        ]);
    }
}
