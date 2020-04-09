<?php

namespace App\DataTables;

use App\VoteProviderRewardGroup;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VoteProviderRewardGroupsDataTable extends DataTable
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
            ->addColumn('action', 'votes.rewardgroups.datatables.actions')
            ->editColumn('voteproviders', 'votes.rewardgroups.datatables.providers')
            ->editColumn('enabled', function ($page)
            {
                if ($page->enabled)
                {
                    return '<label class="badge badge-soft-primary">Enabled</label>';
                }

                return '<label class="badge badge-soft-danger">Disabled</label>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'voteproviders', 'enabled']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VoteProviderRewardGroup $model)
    {
        return $model->with(['voteproviders'])->withCount(['logs as completed_vote_calls' => function ($query)
        {
            $query->voted();
        }, 'rewards as total_rewards_count', 'rewards as enabled_rewards_count' => function ($query)
        {
            $query->where('enabled', true);
        }, ])->where(function ($query)
        {
            if (request()->filled('vote_provider_id'))
            {
                $query->where('vote_provider_id', request()->vote_provider_id);
            }
        })->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('voteproviderrewardgroups-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->orderBy(7)
            ->pageLength(20)
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
            Column::make('voteproviders', 'voteproviders.name')->title('Vote Providers')->orderable(false),
            Column::make('enabled_rewards_count')->searchable(false),
            Column::make('total_rewards_count')->searchable(false),
            Column::make('completed_vote_calls')->searchable(false),
            Column::make('enabled'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
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
        return 'VoteProviderRewardGroups_' . date('YmdHis');
    }
}
