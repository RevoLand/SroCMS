@extends('layout')

@section('pagetitle', 'Order History')
@section('contenttitle', 'Order History')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="user-order-history bg-dark px-3 py-3 shadow-sm rounded-sm">
            <!--begin: Datatable -->
            {!! $dataTable->table(['class' => 'table table-striped table-bordered dataTable responsive-md']) !!}
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
@endsection
