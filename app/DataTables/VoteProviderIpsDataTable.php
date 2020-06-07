<?php

namespace App\DataTables;

use App\VoteProviderIp;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VoteProviderIpsDataTable extends DataTable
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
            ->addColumn('action', 'votes.providers.ips.datatables.actions')
            ->addColumn('callbacks_from_ip', function (VoteProviderIp $voteProviderIp)
            {
                return $voteProviderIp->logs->where('callback_ip', $voteProviderIp->ip)->count();
            })
            ->editColumn('created_at', function (VoteProviderIp $voteProviderIp)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $voteProviderIp->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $voteProviderIp->created_at . '</div>';
            })
            ->editColumn('updated_at', function (VoteProviderIp $voteProviderIp)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $voteProviderIp->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $voteProviderIp->updated_at . '</div>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'created_at', 'updated_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VoteProviderIp $model)
    {
        return $model->with('logs')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('voteproviderips-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200 text-900'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
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
            Column::make('ip'),
            Column::make('callbacks_from_ip')->title('Callbacks Completed from IP'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
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
        return 'VoteProviderIps_' . date('YmdHis');
    }
}
