@extends('layout')

@section('pagetitle', 'Vote Logs')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Vote Logs</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.index') }}" class="kt-subheader__breadcrumbs-link">Vote System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.index') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Logs</a>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Subheader -->
    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @if (session('message'))
        <div class="row">
            <div class="col">
                <div class="alert alert-light alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-check-square kt-font-brand"></i></div>
                    <div class="alert-text">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Vote Logs
                    </h3>
                </div>
                @if(request()->hasAny(['user_id', 'vote_provider_id', 'reward_group_id']))
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.votes.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-eraser"></i> Clear Filters
                        </a>
                    </div>
                </div>
                @endif
            </div>
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                {!! $dataTable->table(['class' => 'table table-bordered table-hover table-checkable dataTable responsive dtr-inline'], true) !!}
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
<script src="{{ asset('vendor/axios.min.js') }}"></script>
{!! Theme::js('plugins/custom/datatables/datatables.bundle.js') !!}
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
    $(".kt-portlet__body").on('submit', 'form', function(event) {
        event.preventDefault();
        axios.patch(event.target.action)
            .then(response => {
                $('#votelogs-table').DataTable().draw(false);
                swal.fire( 'Success!', response.data.message, 'success');
            })
            .catch(error => {
                var errors = '<ul class="list-unstyled">';
                jQuery.each(error.response.data.errors, function (key, value) {
                    errors += '<li>';
                    errors += value;
                    errors += '</li>';
                });
                errors += '</ul>';

                swal.fire({
                    type: 'error',
                    title: error.response.data.message,
                    html: errors
                });
            });
        });
    </script>
@endsection