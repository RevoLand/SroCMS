@extends('layout')

@section('pagetitle', 'Article Comments')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Comments</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.index') }}" class="kt-subheader__breadcrumbs-link">Articles</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.comments.index') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Comments</a>
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
                        Comments
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.articles.comments.index', ['is_approved' => 0]) }}" class="btn btn-accent btn-upper btn-sm btn-bold">
                            <i class="la la-comment"></i> Comments Awaiting Approval
                        </a>
                        <a href="{{ route('admin.articles.comments.index', ['is_visible' => 0]) }}" class="btn btn-warning btn-upper btn-sm btn-bold">
                            <i class="la la-comment"></i> Hidden Comments
                        </a>
                        <a href="{{ route('admin.articles.comments.index', ['is_visible' => 1, 'is_approved' => 1]) }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-comment"></i> Approved & Visible Comments
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                {!! $dataTable->table(['class' => 'table table-striped- table-bordered table-hover table-checkable dataTable no-footer responsive dtr-inline'], true) !!}
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
    $(".kt-portlet__body").on('submit','form', function(event) {
        event.preventDefault();
        switch (event.target.dataset.action) {
            case 'delete':
            swal.fire({ title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(event.target.action)
                        .then(response => {
                            $('tr#' + event.target.dataset.id).fadeOut("slow", function() {
                                $('#articlecomments-table').DataTable().draw(false);
                                swal.fire( 'Deleted!', response.data.message, 'success');
                            });
                        })
                        .catch(error => {
                            swal.fire( 'Error!', error.response.data.message, 'error');
                        });
                    }
                })
            break;
            case 'toggle-visibility':
            case 'toggle-approved':
                axios.patch(event.target.action)
                    .then(response => {
                        $('#articlecomments-table').DataTable().draw(false);
                        swal.fire( 'Updated!', response.data.message, 'success');
                    })
                    .catch(error => {
                        swal.fire( 'Error!', error.response.data.message, 'error');
                    });
            break;
        }
    });
    </script>
@endsection
