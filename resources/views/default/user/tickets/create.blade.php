@extends('layout')

@section('pagetitle', 'New Ticket')
@section('contenttitle', 'New Ticket')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="user-ticket-creation-page bg-dark px-3 py-3 shadow-sm rounded-sm">
            <div class="row">
                <div class="col">
                    @isset($activeBan)
                    <h5>Your access to the Ticket System has been restricted until: {{ $activeBan->ban_end }}</h5>
                    @else
                    <div class="ticket-form pb-3">
                        @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        {!! Form::open(['route' => 'users.tickets.store', 'method' => 'POST', 'files' => true]) !!}
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="custom-control custom-select" id="category" name="category" required>
                                    @foreach($usableCategories as $category)
                                        <option value="{{ $category->id }}" >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" minlength="6" maxlength="100" required value="{{ old('title') }}">
                            </div>
                            @isset($userOrders)
                            <div class="form-group">
                                <label for="order">Related Order (?)</label>
                                <select class="custom-control custom-select" id="order" name="order">
                                    <option selected></option>
                                    @foreach($userOrders as $order)
                                        <option value="{{ $order->id }}">#{{ $order->id }} ({{ $order->created_at }})</option>
                                    @endforeach
                                </select>
                                <p class="text-muted font-italic">Select the Order you have placed if this ticket is related to an Order.</p>
                            </div>
                            @endisset
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" minlength="20" maxlength="1800" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select id="priority" name="priority" class="custom-control custom-select" required>
                                    @foreach(config('constants.ticket_system.priority') as $key => $priority)
                                        <option value="{{ $key}}" >{{ $priority['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(setting('ticketsystem.attachments.maxfilecount', 3) > 0)
                            <div class="form-group">
                                <label for="attachments">Attachments: <div class="text-muted font-italic">(Maximum allowed attachment count per message: {{ setting('ticketsystem.attachments.maxfilecount', 3) }})</div></label>
                                <input type="file" class="form-control form-control-file" id="attachments" name="attachments[]" accept="image/*" multiple>
                                <input type="hidden" name="MAX_FILE_SIZE" value="{{ setting('ticketsystem.attachments.maxfilesize', 1024) }}" />
                            </div>
                            @endif
                            <button type="submit" class="btn btn-block btn-lg btn-primary">Create Ticket</button>
                        {!! Form::close() !!}
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
