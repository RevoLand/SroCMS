@extends('layout')

@section('pagetitle', 'Article Comments')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Article Comments</h5>
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

<script>
    $(".card-body").on('submit','form', function(event) {
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
                                swal.fire({
                                    title: response.data.title,
                                    html: response.data.message,
                                    icon: response.data.icon
                                });
                            });
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
                    }
                })
            break;
            case 'toggle-visibility':
            case 'toggle-approved':
                axios.patch(event.target.action)
                    .then(response => {
                        $('#articlecomments-table').DataTable().draw(false);
                        swal.fire({
                            title: response.data.title,
                            html: response.data.message,
                            icon: response.data.icon
                        });
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
                            icon: 'error',
                            title: error.response.data.message,
                            html: errors
                        });
                    });
            break;
        }
    });
    </script>
@endsection
