@extends('layout')

@section('pagetitle')
Ticket System
@endsection

@section('contenttitle')
Ticket System
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="user-tickets bg-dark px-3 py-3 shadow-sm rounded-sm">
            <a class="btn btn-primary float-left" href="{{ route('users.tickets.create') }}">
                New Ticket
            </a>
            <!--begin: Datatable -->
            {!! $dataTable->table(['class' => 'table table-striped table-bordered dataTable responsive-md'], true) !!}
            <!--end: Datatable -->
        </div>
    </div>
</div>
@endsection


@section('js')
<script src="{{ asset('vendor/datatables/datatables.bundle.js') }}"></script>
{!! $dataTable->scripts() !!}
<script>
    $(document).ready( function () {
        let dataTableCustomSearchOptions = [
            {
                'index': 3,
                'selector': '#priority_select'
            },
            {
                'index': 4,
                'selector': '#status_select'
            }
        ];

        _.forEach(dataTableCustomSearchOptions, function(value) {
            $(value.selector).on('change', function() {
                let searchValue = $(this).children("option:selected").val();
                $('#usertickets-table').DataTable().column(value.index).search(searchValue).draw();
            });
        });
    });
    </script>
@endsection
