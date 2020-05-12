<?php

namespace App\Http\Controllers;

use Alert;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if (setting('users.email_must_be_verified', 0))
        {
            $this->middleware('verified');
        }

        $this->middleware('throttle:6,3')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function store(Ticket $ticket)
    {
        if ($ticket->user_id != auth()->user()->JID)
        {
            return redirect()->route('users.tickets.index');
        }

        if ($ticket->status == config('constants.ticket_system.status_from_name.Closed'))
        {
            Alert::warning('You can\'t post a message to this ticket!');

            return redirect()->back();
        }

        $validated = request()->validate([
            'message' => ['required', 'string', 'max:1800', 'min:6'],
            'close_ticket' => ['sometimes', 'boolean'],
            'attachments' => ['sometimes', 'array', 'max:' . setting('ticketsystem.attachments.maxfilecount', 3)],
            'attachments.*' => ['image', 'distinct', 'max:' . setting('ticketsystem.attachments.maxfilesize', 1024), Rule::dimensions()->maxWidth(3840)->maxHeight(2160)],
        ]);

        $newMessage = $ticket->messages()->create([
            'user_id' => auth()->user()->JID,
            'content' => $validated['message'],
            'ip' => request()->getClientIp(),
        ]);

        if (array_key_exists('attachments', $validated))
        {
            foreach ($validated['attachments'] as $attachment)
            {
                if (!$attachment->isValid())
                {
                    continue;
                }

                $storedFile = $attachment->store(auth()->user()->JID, 'tickets');

                $newMessage->attachments()->create([
                    'name' => $storedFile,
                ]);
            }
        }

        if (request()->has('close_ticket'))
        {
            $ticket->update([
                'status' => config('constants.ticket_system.status_from_name.Closed'),
            ]);
        }
        else
        {
            if ($ticket->status != config('constants.ticket_system.status_from_name.New'))
            {
                $ticket->update([
                    'status' => config('constants.ticket_system.status_from_name.NotAnswered'),
                ]);
            }
        }

        Alert::success('Success!', 'Your message has been sent to the support team.');

        return redirect()->route('users.tickets.show', $ticket);
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
}
