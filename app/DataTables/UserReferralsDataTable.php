<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserReferralsDataTable extends DataTable
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
            ->editColumn('referrerUser', function ($referral)
            {
                $referralPoints = $referral->load(['referrerUser.balanceLogs' => function ($balancelog) use ($referral)
                {
                    $balancelog->source(config('constants.balance.source.referred_user_reward'))->sourceUser($referral->user->JID);
                }, ]);

                $groupedPoints = $referralPoints->referrerUser->balanceLogs->groupBy('balance_type');

                return view('user.referrals.datatables.pointsearned', compact('groupedPoints'));
            })
            ->editColumn('user', function ($referral)
            {
                return "<a href='" . route('users.show_user', $referral->user->JID) . "'>{$referral->user->getName()}</a>";
            })
            ->rawColumns(['user', 'referrerUser']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UserReferral $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return auth()->user()->referrals()->with('user')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('userreferrals-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->responsive(true)
            ->orderBy(1)
            ->buttons(
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
            Column::make('referrerUser', 'referrer_user_id')->title('Points Earned'),
            Column::make('created_at')->title('Date'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'UserReferrals_' . date('YmdHis');
    }
}
