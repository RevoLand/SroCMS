<?php

namespace App\DataTables;

use App\VoteProviderIp;
use Yajra\DataTables\Html\Button;
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
            ->addColumn('callbacks_from_ip', function ($voteProviderIp)
            {
                return $voteProviderIp->logs->where('callback_ip', $voteProviderIp->ip)->count();
            })
            ->setRowId('id')
            ->rawColumns(['action']);
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
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orderBy(3)
            ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
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
            Column::make('callbacks_from_ip')->title('Callbacks from IP'),
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
