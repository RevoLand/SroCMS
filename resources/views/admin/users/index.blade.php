@extends('layout')

@section('pagetitle', 'Users')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Users</h5>
        <div>
            <a class="btn btn-falcon-primary" href="{{ route('admin.users.create') }}">Create</a>
        </div>
    </div>
    <div class="card-body bg-light px-0">
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
