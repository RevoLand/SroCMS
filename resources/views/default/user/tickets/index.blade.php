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
            {!! $dataTable->table(['class' => 'table table-striped table-bordered dataTable responsive-md'], false) !!}
            <!--end: Datatable -->
        </div>
    </div>
</div>
@endsection

@section('css')
<link media="all" type="text/css" rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
<link media="all" type="text/css" rel="stylesheet" href="{{ asset('vendor/datatables/css/responsive.bootstrap4.min.css') }}">
{{-- <link media="all" type="text/css" rel="stylesheet" href="{{ asset('vendor/datatables/css/rowGroup.bootstrap4.min.css') }}"> --}}
@endsection

@section('js')
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/responsive.bootstrap4.min.js') }}"></script>
{{-- <script src="{{ asset('vendor/datatables/js/dataTables.rowGroup.min.js') }}"></script> --}}
{!! $dataTable->scripts() !!}
<script>
    $(document).ready( function () {
        let dataTableCustomSearchOptions = [
            {
                'index': 4,
                'selector': '#priority_select'
            },
            {
                'index': 5,
                'selector': '#status_select'
            }
        ];

        dataTableCustomSearchOptions.forEach(function(value) {
            $(value.selector).on('change', function() {
                let searchValue = $(this).children("option:selected").val();
                $('#usertickets-table').DataTable().column(value.index).search(searchValue).draw();
            });
        });
    });
</script>
@endsection
