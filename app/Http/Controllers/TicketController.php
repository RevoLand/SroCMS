<?php

namespace App\Http\Controllers;

use Alert;
use App\DataTables\UserTicketsDataTable;
use App\ItemMallOrder;
use App\Ticket;
use App\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if (setting('users.email_must_be_verified', 0))
        {
            $this->middleware('verified');
        }

        if (!setting('ticketsystem.enabled', 1))
        {
            return redirect()->route('users.current_user')->send();
        }

        $this->middleware('throttle:60,1')->only(['index', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserTicketsDataTable $dataTable)
    {
        return $dataTable->render('user.tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!setting('ticketsystem.acceptnewtickets', 1))
        {
            return redirect()->route('users.tickets.index')->send();
        }

        $usableCategories = TicketCategory::enabled()->get();
        $userOrders = auth()->user()->orders()->latest()->get();
        $activeBan = auth()->user()->activeTicketBans()->first();

        return view('user.tickets.create', compact('usableCategories', 'userOrders', 'activeBan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!setting('ticketsystem.acceptnewtickets', 1))
        {
            return redirect()->route('users.tickets.index')->send();
        }

        $activeBan = auth()->user()->activeTicketBans()->first();
        if ($activeBan)
        {
            Alert::error('Error!', "Your access to the Ticket System has been restricted until: {$activeBan->ban_end}");

            return redirect()->route('users.tickets.index');
        }

        $validated = request()->validate([
            'category' => ['required', 'integer', 'exists:App\TicketCategory,id'],
            'title' => ['required', 'string', 'min:6', 'max:100'],
            'message' => ['required', 'string', 'min:20', 'max:1800'],
            'priority' => ['required', 'integer', Rule::in(collect(config('constants.ticket_system.priority_array')))],
            'order' => ['sometimes', 'nullable', 'integer', 'exists:App\ItemMallOrder,id'],
            'attachments' => ['sometimes', 'array', 'max:' . setting('ticketsystem.attachments.maxfilecount', 3)],
            'attachments.*' => [
                'image',
                'distinct',
                'max:' . setting('ticketsystem.attachments.maxfilesize', 1024),
                Rule::dimensions()->maxWidth(3840)->maxHeight(2160),
            ],
        ]);

        $category = TicketCategory::find($validated['category']);
        if (!$category->enabled)
        {
            Alert::error('Error!', 'You can\'t submit a ticket to this category.');

            return redirect()->route('users.tickets.create');
        }

        if ($request->filled('order'))
        {
            $order = ItemMallOrder::find($validated['order']);

            if ($order->user_id != auth()->user()->JID)
            {
                Alert::error('Error!', 'Selected order doesn\'t belongs to you!');

                return redirect()->route('users.tickets.create');
            }
        }

        $ticket = Ticket::create([
            'user_id' => auth()->user()->JID,
            'ticket_category_id' => $validated['category'],
            'title' => $validated['title'],
            'priority' => $validated['priority'],
            'item_mall_order_id' => request('order'),
            'status' => config('constants.ticket_system.status_from_name.New'),
            'ip' => request()->getClientIp(),
        ]);

        $ticketMessage = $ticket->messages()->create([
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

                $ticketMessage->attachments()->create([
                    'name' => $storedFile,
                ]);
            }
        }

        Alert::success('Success!', 'Your ticket has been created and our support team will be looking into it ASAP.');

        return redirect()->route('users.tickets.show', $ticket);
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
        if ($ticket->user_id != auth()->user()->JID)
        {
            return redirect()->route('home');
        }

        $ticket->load(['category', 'messages' => function ($query)
        {
            $query->with(['user', 'attachments']);
        }, 'order', 'user', 'assignedUser', ]);

        return view('user.tickets.show', compact('ticket'));
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
