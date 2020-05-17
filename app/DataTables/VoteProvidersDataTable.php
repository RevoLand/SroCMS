<?php

namespace App\DataTables;

use App\VoteProvider;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VoteProvidersDataTable extends DataTable
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
            ->addColumn('action', 'votes.providers.datatables.actions')
            ->addColumn('vote_completion_rate', function ($provider)
            {
                return ($provider->total_vote_count) ? number_format($provider->completed_vote_count * 100 / $provider->total_vote_count, 3) : 0;
            })
            ->editColumn('enabled', function (VoteProvider $voteprovider)
            {
                if ($voteprovider->enabled)
                {
                    return '<label class="badge badge-soft-primary">Enabled</label>';
                }

                return '<label class="badge badge-soft-danger">Disabled</label>';
            })
            ->editColumn('created_at', function (VoteProvider $voteprovider)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $voteprovider->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $voteprovider->created_at . '</div>';
            })
            ->editColumn('updated_at', function (VoteProvider $voteprovider)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $voteprovider->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $voteprovider->updated_at . '</div>';
            })
            ->rawColumns(['action', 'enabled', 'created_at', 'updated_at'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VoteProvider $model)
    {
        return $model->withCount(['votelogs as total_vote_count', 'votelogs as completed_vote_count' => function ($query)
        {
            $query->where('voted', true);
        }, ])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('voteproviders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->orderBy(8);
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
            Column::make('name'),
            Column::make('minutes_between_votes'),
            Column::make('total_vote_count')->title('Total Votes Started')->searchable(false),
            Column::make('completed_vote_count')->title('Succeed Votes')->searchable(false),
            Column::computed('vote_completion_rate')->title('Completion Rate %'),
            Column::make('enabled'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->title('Actions')
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
        return 'VoteProviders_' . date('YmdHis');
    }
}
