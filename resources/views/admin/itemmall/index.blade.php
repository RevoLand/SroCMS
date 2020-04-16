@extends('layout')

@section('pagetitle', 'Orders')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Orders</h5>
    </div>
    <div class="card-body bg-light px-0">
        @include('components.message')
        <div class="row">
            <div class="col-12">
                {!! $dataTable->table([], true) !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
{!! Theme::css('lib/datatables-bs4/dataTables.bootstrap4.min.css') !!}
{!! Theme::css('lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') !!}
{!! Theme::css('lib/datatables-rowgroup/css/rowGroup.bootstrap4.min.css') !!}
@endsection

@section('js')
<script src="{{ asset('vendor/axios.min.js') }}"></script>

{!! Theme::js('lib/datatables/js/jquery.dataTables.min.js') !!}
{!! Theme::js('lib/datatables-bs4/dataTables.bootstrap4.min.js') !!}
{!! Theme::js('lib/datatables.net-responsive/dataTables.responsive.js') !!}
{!! Theme::js('lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') !!}
{!! Theme::js('lib/datatables-rowgroup/js/dataTables.rowGroup.min.js') !!}
{!!  $dataTable->scripts() !!}
@endsection
