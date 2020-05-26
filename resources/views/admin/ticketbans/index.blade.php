@extends('layout')

@section('pagetitle', 'Ticket Bans')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Ticket Bans</h5>
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
{!! $dataTable->scripts() !!}
{!! Theme::js('lib/select2/select2.min.js') !!}
<script>
$(document).ready( function () {
    $('.select2').select2({});

    $('.user_select2').select2({
        placeholder: 'Search for User',
        minimumInputLength: 2,
        allowClear: true,
        dropdownAutoWidth: true,
        ajax: {
            url: route('admin.ajax.users.get_usernames'),
            dataType: 'json',
            delay: 300,
            cache: true,
            data: function(params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                }
            },
            processResults: function (response, params) {
                return {
                    results: response.data,
                    pagination: {
                        more: ((params.page || 1) < response.last_page)
                    }
                };
          },
        }
    });

    let dataTableCustomSearchOptions = [
        {
            'index': 1,
            'selector': '#user_select'
        },
        {
            'index': 3,
            'selector': '#assigner_user_select'
        }
    ];

    _.forEach(dataTableCustomSearchOptions, function(value) {
        $(value.selector).on('change', function() {
            let searchValue = $(this).children("option:selected").val();
            $('#ticketbans-datatable').DataTable().column(value.index).search(searchValue).draw();
        });
    });
});
</script>
<script>
    $(".card-body").on('submit','form', function(event) {
        event.preventDefault();
        switch (event.target.dataset.action) {
            case 'cancel-ban':
                axios.patch(event.target.action)
                    .then(response => {
                        $('#ticketbans-datatable').DataTable().draw(false);
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
