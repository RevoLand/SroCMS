@extends('layout')

@section('pagetitle', 'Users')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Users</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.pages.index') }}" class="kt-subheader__breadcrumbs-link">Users</a>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Subheader -->
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Users
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                {!! $dataTable->table() !!}
                <!--end: Datatable -->
            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>
@endsection

@section('css')
    {!! Theme::css('plugins/custom/datatables/datatables.bundle.css') !!}
@endsection

@section('js')
<script src="{{ asset('vendor/jquery-1.10.2.min.js') }}"></script>
{!! Theme::js('plugins/custom/datatables/datatables.bundle.js') !!}
<script src="{{ asset('vendor/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
@endsection
