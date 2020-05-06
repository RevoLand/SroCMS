@extends('layout')

@section('pagetitle')
Show Ticket: {{ $ticket->title }}
@endsection

@section('contenttitle')
Ticket: {{ $ticket->title }}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="user-show-ticket bg-dark p-3 shadow-sm rounded-sm">
            <h3 class="ticket-title pt-1 pb-3">
                {{ $ticket->title }}
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('users.tickets.index') }}">My Tickets</a>
                </div>
            </h3>
            <div class="ticket-meta">
                <div class="row">
                    <div class="col-4 d-flex align-items-baseline justify-content-between">
                        Category:
                        <div class="text-muted font-italic">
                            {{ $ticket->category->name }}
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-baseline justify-content-between">
                        Status:
                        <label class="label btn-sm {{ config('constants.ticket_system.status.' . $ticket->status . '.color') }}">
                            {{ config('constants.ticket_system.status.' . $ticket->status . '.name') }}
                        </label>
                    </div>
                    <div class="col-4 d-flex align-items-baseline justify-content-between">
                        Priority:
                        <label class="label btn-sm {{ config('constants.ticket_system.priority.' . $ticket->priority . '.color') }}">
                            {{ config('constants.ticket_system.priority.' . $ticket->priority . '.name') }}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-flex align-items-baseline justify-content-between">
                        Assigned to:
                        <div class="text-muted font-italic">
                            @if ($ticket->assignedUser)
                                <a href="{{ route('users.show_user', $ticket->assignedUser) }}">{{ $ticket->assignedUser->getName() }}</a>
                            @else
                            -
                            @endif
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-baseline justify-content-between">
                        Order:
                        <div class="text-muted font-italic">
                            @if ($ticket->order)
                                <a href="{{ route('user.orders.show', $ticket->order) }}">#{{ $ticket->order->id }}</a>
                            @else
                            -
                            @endif
                        </div>
                    </div>
                    <div class="col-4 d-flex align-items-baseline justify-content-between">
                        Created at:
                        <div class="text-muted font-italic text-right" data-toggle="tooltip" title="{{ $ticket->created_at }}">{{ $ticket->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 3, 'short' => true]) }}</div>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="ticket-body">
                @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                @foreach($ticket->messages as $ticketMessage)
                <div class="row">
                    <div class="col-md-3 p-2 border-right border-secondary">
                        <h5>{{ $ticketMessage->user->getName() }}</h5>
                    </div>
                    <div class="col-md-9 p-3">
                        <p>{{ $ticketMessage->content }}</p>
                        @if (count($ticketMessage->attachments) > 0)
                        <div class="alert alert-secondary" role="alert">
                            @foreach($ticketMessage->attachments as $attachment)
                                <li class="list-unstyled align-content-center my-1">
                                    <a href="{{ $attachment->file_url }}" target="_blank" rel="noopener">Attachment #{{ $loop->index + 1 }}</a>
                                    <div class="text-muted font-italic float-right">{{ $attachment->created_at }}</div>
                                </li>
                            @endforeach
                        </div>
                        @endif
                        <div class="text-muted text-right" data-toggle="tooltip" title="{{ $ticketMessage->created_at }}">{{ $ticketMessage->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 3, 'short' => true]) }}</div>
                    </div>
                </div>
                <hr class="my-4">
                @endforeach
            </div>
            <div class="ticket-answer">
                <div class="row">
                    <div class="col-md-12">
                        @if ($ticket->status == config('constants.ticket_system.status_from_name.Closed'))
                        <p class="text-muted">You can't answer to this ticket.</p>
                        @else
                            {!! Form::open(['route' => ['users.tickets.messages.store', $ticket], 'method' => 'POST', 'files' => true]) !!}
                            <div class="form-group">
                                <label for="message">Your Message:</label>
                                <textarea class="form-control" id="message" name="message" placeholder="" minlength="6" maxlength="1800" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="attachments">Attachments: <div class="text-muted font-italic">(Maximum allowed attachment count per message: {{ setting('ticketsystem.attachments.maxfilecount', 3) }})</div></label>
                                <input type="file" class="form-control form-control-file" id="attachments" name="attachments[]" accept="image/*" multiple>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input id="close_ticket" class="custom-control-input" type="checkbox" name="close_ticket" value="1">
                                <label for="close_ticket" class="custom-control-label">Close Ticket</label>
                            </div>
                            <button class="btn btn-primary btn-block" type="submit">Send Message</button>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
