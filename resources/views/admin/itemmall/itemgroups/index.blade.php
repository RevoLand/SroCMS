@extends('layout')

@section('pagetitle', 'Web Item Mall Item Groups')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Item Groups</h5>
        <div>
            <a class="btn btn-falcon-primary mr-2" href="{{ route('admin.itemmall.itemgroups.create') }}">Create</a>
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

<script>
    let dataTableCustomSearchOptions = [
        {
            'index': 3,
            'selector': '#payment_type_select'
        },
        {
            'index': 6,
            'selector': '#on_sale_select'
        },
        {
            'index': 7,
            'selector': '#featured_select'
        },
        {
            'index': 8,
            'selector': '#limit_total_purchases_select'
        },
        {
            'index': 11,
            'selector': '#enabled_select'
        }
    ];

    _.forEach(dataTableCustomSearchOptions, function(value) {
        $(value.selector).on('change', function() {
            let searchValue = $(this).children("option:selected").val();
            $('#itemmallitemgroups-table').DataTable().column(value.index).search(searchValue).draw();
        });
    });
</script>

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
                            $('#itemmallitemgroups-table').DataTable().draw(false);
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
                                type: 'error',
                                title: error.response.data.message,
                                html: errors
                            });
                        });
                    }
                })
            break;
            case 'toggle-enabled':
                axios.patch(event.target.action)
                    .then(response => {
                        $('#itemmallitemgroups-table').DataTable().draw(false);
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
