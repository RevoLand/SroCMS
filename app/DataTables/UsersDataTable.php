<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', 'users.datatables.actions')
            ->editColumn('orders', function (User $user)
            {
                return '<a href="' . route('admin.itemmall.index', ['user_id' => $user->JID]) . '">' . $user->orders->count() . '</a>';
            })
            ->editColumn('referrals', function (User $user)
            {
                // TODO: Referrals List/Page link
                return '<a href="' . route('admin.itemmall.index', ['user_id' => $user->JID]) . '">' . $user->referrals->count() . '</a>';
            })
            ->editColumn('vote_logs', function (User $user)
            {
                $totalVotes = $user->voteLogs->count();
                $rewardedVotes = $user->voteLogs->where('voted', true)->count();
                $completionRate = (!$totalVotes) ? 0 : intval($rewardedVotes * 100 / $totalVotes);

                return view('users.datatables.votelogs', compact('totalVotes', 'rewardedVotes', 'completionRate'));
            })
            ->editColumn('regtime', function (User $user)
            {
                if (!isset($user->regtime))
                {
                    return '';
                }

                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $user->regtime->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $user->regtime . '</div>';
            })
            ->editColumn('StrUserID', 'users.datatables.user')
            ->editColumn('characternames', 'users.datatables.characternames')
            ->setRowId('id')
            ->rawColumns(['action', 'orders', 'referrals', 'vote_logs', 'regtime', 'StrUserID', 'characternames']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        // TODO: withCount düzeltildiğinde elden geçirilecek.
        return $model->with(['orders', 'referrals', 'voteLogs', 'characternames.character'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white table-sm'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 20, 50, 100, 250, 500, 1000])
            ->pageLength(20)
            ->orderBy(0, 'asc')
            ->pagingType('first_last_numbers');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('JID', 'JID'),
            Column::make('StrUserID')->title('Username'),
            Column::make('Name'),
            Column::make('Email'),
            Column::make('characternames', 'characternames.CharName')->title('Characters')->sortable(false),
            Column::computed('orders'),
            Column::computed('referrals'),
            Column::computed('vote_logs'),
            Column::make('regtime'),
            Column::make('reg_ip'),
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
        return 'Users_' . date('YmdHis');
    }
}
