<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
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
            ->editColumn('orders', function ($user)
            {
                return '<a href="' . route('admin.itemmall.index', ['user_id' => $user->JID]) . '">' . $user->orders->count() . '</a>';
            })
            ->editColumn('referrals', function ($user)
            {
                // TODO: Referrals List/Page link
                return '<a href="' . route('admin.itemmall.index', ['user_id' => $user->JID]) . '">' . $user->referrals->count() . '</a>';
            })
            ->editColumn('vote_logs', function ($user)
            {
                $totalVotes = $user->voteLogs->count();
                $rewardedVotes = $user->voteLogs->where('voted', true)->count();
                $completionRate = (!$totalVotes) ? 0 : intval($rewardedVotes * 100 / $totalVotes);

                return view('users.datatables.votelogs', compact('totalVotes', 'rewardedVotes', 'completionRate'));
            })
            ->setRowId('id')
            ->rawColumns(['action', 'orders', 'referrals', 'vote_logs']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->with(['orders', 'referrals', 'voteLogs'])->newQuery();
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
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orderBy(0, 'asc')
            ->pagingType('first_last_numbers')
            ->lengthMenu([10, 25, 50, 100, 250, 1000])
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
            Column::make('JID', 'JID'),
            Column::make('StrUserID'),
            Column::make('Name'),
            Column::make('Email'),
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
