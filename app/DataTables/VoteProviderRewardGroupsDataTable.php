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
            ->addColumn('action', 'votes.providers.rewardgroups.datatables.actions')
            ->editColumn('voteproviders', 'votes.providers.rewardgroups.datatables.providers')
            ->editColumn('enabled', function ($page)
            {
                if ($page->enabled)
                {
                    return '<label class="badge badge-primary">Enabled</label>';
                }

                return '<label class="badge badge-danger">Disabled</label>';
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
        return $model->with(['voteproviders', 'rewards'])->withCount(['voteproviders as total_rewards_count', 'voteproviders as enabled_rewards_count' => function ($query)
        {
            $query->where('enabled', true);
        }, ])->where(function ($query)
        {
            if (request()->filled('vote_provider_id'))
            {
                $query->where('vote_provider_id', request()->vote_provider_id);
            }

            $query->whereHas('voteproviders', function ($q)
            {
                $q->enabled();
            });
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
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
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
            Column::make('enabled_rewards_count'),
            Column::make('total_rewards_count'),
            Column::make('enabled'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
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
