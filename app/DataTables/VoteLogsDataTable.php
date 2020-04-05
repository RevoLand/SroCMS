<?php

namespace App\DataTables;

use App\VoteLog;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VoteLogsDataTable extends DataTable
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
            ->addColumn('action', 'votes.datatables.actions')
            ->setRowId('id')
            ->editColumn('voted', function ($votelog)
            {
                if ($votelog->voted)
                {
                    return '<label class="badge badge-primary">Yes</label>';
                }

                return '<label class="badge badge-danger">No</label>';
            })
            ->editColumn('active', function ($votelog)
            {
                if ($votelog->active)
                {
                    return '<label class="badge badge-primary">Yes</label>';
                }

                return '<label class="badge badge-danger">No</label>';
            })
            ->editColumn('user', 'votes.datatables.user')
            ->editColumn('voteprovider', 'votes.datatables.voteprovider')
            ->editColumn('rewardgroup', 'votes.datatables.rewardgroup')
            ->rawColumns(['action', 'voted', 'active', 'user', 'voteprovider', 'rewardgroup']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VoteLog $model)
    {
        return $model->with(['user', 'voteprovider', 'rewardgroup'])->where(function ($query)
        {
            if (request()->filled('user_id'))
            {
                $query->where('user_id', request('user_id'));
            }

            if (request()->filled('vote_provider_id'))
            {
                $query->where('vote_provider_id', request('vote_provider_id'));
            }

            if (request()->filled('reward_group_id'))
            {
                $query->where('selected_reward_group_id', request('reward_group_id'));
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
            ->setTableId('votelogs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orderBy(9)
            ->rowGroupDataSrc(['voteprovider', 'rewardgroup'])
            ->buttons(
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
            Column::make('user', 'user_id')->title('User'),
            Column::make('voteprovider', 'voteprovider.name')->title('Vote Provider'),
            Column::make('rewardgroup', 'rewardgroup.name')->title('Reward Group Name'),
            Column::make('voted'),
            Column::make('active'),
            Column::make('user_ip'),
            Column::make('callback_ip'),
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
        return 'Votes_' . date('YmdHis');
    }
}
