@extends('layout')

@section('pagetitle', 'Sipariş Geçmişim')
@section('contenttitle', 'Sipariş Geçmişim')

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


@section('js')
<script src="{{ asset('vendor/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
@endsection
