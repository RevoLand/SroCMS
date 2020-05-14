<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\TicketReplied;
use App\Ticket;
use App\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketMessageController extends Controller
{
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
    public function store(Request $request, Ticket $ticket)
    {
        $validated = request()->validate([
            'message' => ['required', 'string', 'max:1800', 'min:6'],
            'close_ticket' => ['required', 'boolean'],
            'attachments' => ['sometimes', 'array', 'max:' . setting('ticketsystem.attachments.admin_maxfilecount', 3)],
            'attachments.*' => ['image', 'distinct', 'max:' . setting('ticketsystem.attachments.admin_maxfilesize', 2048), Rule::dimensions()->maxWidth(3840)->maxHeight(2160)],
        ]);

        $newMessage = $ticket->messages()->create([
            'user_id' => auth()->user()->JID,
            'content' => $validated['message'],
            'html' => true,
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

        if (!$validated['close_ticket'])
        {
            if ($ticket->status != config('constants.ticket_system.status_from_name.Answered') && $ticket->status != config('constants.ticket_system.status_from_name.Closed'))
            {
                $ticket->update([
                    'status' => config('constants.ticket_system.status_from_name.Answered'),
                ]);
            }
        }
        else
        {
            $ticket->update([
                'status' => config('constants.ticket_system.status_from_name.Closed'),
            ]);
        }

        $ticket->user->notify(new TicketReplied($ticket));

        $newMessage->load(['user', 'attachments']);

        return response()->json([
            'title' => 'Success!',
            'message' => 'Your reply has been sent!',
            'icon' => 'success',
            'new_message' => $newMessage,
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
    public function update(Request $request, TicketMessage $ticketmessage)
    {
        $validated = request()->validate([
            'content' => ['required', 'string', 'max:1800'],
        ]);

        if ($ticketmessage->content != $validated['content'])
        {
            $ticketmessage->history()->create([
                'user_id' => auth()->user()->JID,
                'old_content' => $ticketmessage->content,
                'new_content' => $validated['content'],
            ]);

            $ticketmessage->update($validated);
        }

        return response()->json([
            'title' => 'Success!',
            'message' => 'Message has been successfully updated.',
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
    public function destroy($id)
    {
    }
}
