<?php

namespace App\DataTables;

use App\TicketBan;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TicketBansDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query results from query() method
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('actions', 'ticketbans.datatables.actions')
            ->addColumn('active', function (TicketBan $ticketban)
            {
                if ($ticketban->active)
                {
                    return '<label class="badge badge-soft-danger">Yes</label>';
                }

                return '<label class="badge badge-soft-primary">No</label>';
            })
            ->editColumn('user', 'ticketbans.datatables.user')
            ->editColumn('assigner', 'ticketbans.datatables.assigner')
            ->editColumn('ban_start', function (TicketBan $ticketban)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticketban->ban_start->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticketban->ban_start . '</div>';
            })
            ->editColumn('ban_end', function (TicketBan $ticketban)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticketban->ban_end->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticketban->ban_end . '</div>';
            })
            ->editColumn('created_at', function (TicketBan $ticketban)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticketban->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticketban->created_at . '</div>';
            })
            ->editColumn('updated_at', function (TicketBan $ticketban)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticketban->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticketban->updated_at . '</div>';
            })
            ->rawColumns(['actions', 'user', 'assigner', 'active', 'ban_start', 'ban_end', 'created_at', 'updated_at'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\TicketBansDataTable $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TicketBan $model)
    {
        return $model->with(['user', 'assigner'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('ticketbans-datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 20, 50, 100, 250, 500, 1000])
            ->pageLength(20)
            ->pagingType('first_last_numbers')
            ->orderBy(3);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('user', 'user_id')->footer('<select id="user_select" class="custom-select user_select2"><option></option></select>'),
            Column::computed('active'),
            Column::make('reason'),
            Column::make('assigner', 'assigner_user_id')->title('Banned By')->footer('<select id="assigner_user_select" class="custom-select user_select2"><option></option></select>'),
            Column::make('ban_start'),
            Column::make('ban_end'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TicketBans_' . date('YmdHis');
    }
}
