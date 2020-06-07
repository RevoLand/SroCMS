@extends('layout')

@section('pagetitle', 'Guilds')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Guilds</h5>
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
{!! Theme::css('lib/datatables.net-rowgroup/rowGroup.bootstrap4.min.css') !!}
@endsection

@section('js')
{!! Theme::js('lib/datatables.net/jquery.dataTables.min.js') !!}
{!! Theme::js('lib/datatables-bs4/dataTables.bootstrap4.min.js') !!}
{!! Theme::js('lib/datatables.net-responsive/dataTables.responsive.js') !!}
{!! Theme::js('lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') !!}
{!! Theme::js('lib/datatables.net-rowgroup/dataTables.rowGroup.min.js') !!}
{!! Theme::js('lib/datatables.net-rowgroup/rowGroup.bootstrap4.min.js') !!}
{!!  $dataTable->scripts() !!}
@endsection
