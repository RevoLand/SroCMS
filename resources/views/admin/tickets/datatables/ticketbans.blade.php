@if($model->user->activeTicketBans->count() > 0 || $model->user->ticketBans->count() > 0)
<div class="media align-items-center">
    <div class="media-body">
        <h6 class="mb-0">Active: {{ $model->user->activeTicketBans->count() }}</h6>
        <small class="text-muted font-italic">Total: {{ $model->user->ticketBans->count() }}</small>
    </div>
</div>
@else
-
@endif
