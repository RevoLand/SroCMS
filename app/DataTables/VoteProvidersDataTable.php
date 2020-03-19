<?php

namespace App\DataTables;

use App\VoteProvider;
use Yajra\DataTables\Html\Button;
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
                return ($provider->total_vote_count) ? $provider->completed_vote_count * 100 / $provider->total_vote_count : 0;
            })
            ->editColumn('enabled', function ($page)
            {
                if ($page->enabled)
                {
                    return '<label class="badge badge-primary">Enabled</label>';
                }

                return '<label class="badge badge-danger">Disabled</label>';
            })
            ->rawColumns(['action', 'enabled'])
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
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orderBy(6)
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
            Column::make('name'),
            Column::make('url'),
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
                ->width(130)
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
