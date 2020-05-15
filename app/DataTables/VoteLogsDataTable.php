<?php

namespace App\DataTables;

use App\VoteLog;
use App\VoteProvider;
use App\VoteProviderRewardGroup;
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
                    return '<label class="badge badge-soft-primary">Yes</label>';
                }

                return '<label class="badge badge-soft-danger">No</label>';
            })
            ->editColumn('active', function ($votelog)
            {
                if ($votelog->active)
                {
                    return '<label class="badge badge-soft-primary">Yes</label>';
                }

                return '<label class="badge badge-soft-danger">No</label>';
            })
            ->editColumn('user', 'votes.datatables.user')
            ->editColumn('voteProvider', 'votes.datatables.voteprovider')
            ->editColumn('rewardgroup', 'votes.datatables.rewardgroup')
            ->editColumn('created_at', function ($ticket)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticket->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticket->created_at . '</div>';
            })
            ->editColumn('updated_at', function ($ticket)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticket->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticket->updated_at . '</div>';
            })
            ->rawColumns(['action', 'voted', 'active', 'user', 'voteProvider', 'rewardgroup', 'created_at', 'updated_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VoteLog $model)
    {
        return $model->with(['user', 'voteProvider', 'rewardgroup'])->where(function ($query)
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
        })->select(['vote_logs.*'])->newQuery();
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
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->orders([['4', 'asc'], ['2', 'asc'], ['3', 'asc']])
            ->rowGroupDataSrc(['voteprovider', 'rewardgroup']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $voteProviders = VoteProvider::select(['name'])->whereHas('voteLogs')->get();
        $rewardGroups = VoteProviderRewardGroup::select(['name'])->whereHas('logs')->get();
        $voteProviderOptions = '';
        $rewardGroupOptions = '';

        foreach ($voteProviders as $voteProvider)
        {
            $voteProviderOptions .= '<option>' . $voteProvider->name . '</option>';
        }

        foreach ($rewardGroups as $rewardGroup)
        {
            $rewardGroupOptions .= '<option>' . $rewardGroup->name . '</option>';
        }

        return [
            Column::make('id'),
            Column::make('user', 'user_id')->title('User')->footer('<select id="user_select" class="custom-select user_select2"><option></option></select>'),
            Column::make('voteProvider', 'voteProvider.name')->title('Vote Provider')->footer('<select id="vote_provider_select" class="form-control select2"><option value="" selected>-</option>' . $voteProviderOptions . '</select>'),
            Column::make('rewardgroup', 'rewardgroup.name')->title('Reward Group Name')->footer('<select id="reward_group_select" class="form-control select2"><option value="" selected>-</option>' . $rewardGroupOptions . '</select>'),
            Column::make('voted')->footer('<select id="voted_select" class="form-control select2"><option value="" selected>-</option><option value="1">Voted</option><option value="0">Not Voted</option></select>'),
            Column::make('active')->footer('<select id="active_select" class="form-control select2"><option value="" selected>-</option><option value="1">Yes</option><option value="0">No</option></select>'),
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
