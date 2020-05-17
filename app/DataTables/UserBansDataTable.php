<?php

namespace App\DataTables;

use App\BlockedUser;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserBansDataTable extends DataTable
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
            ->setRowId('id')
            ->addColumn('actions', 'users.bans.datatables.actions')
            ->addColumn('punishment_reason', function (BlockedUser $blockeduser)
            {
                return $blockeduser->punishment->Description;
            })
            ->editColumn('user', 'users.bans.datatables.user')
            ->editColumn('punishment', 'users.bans.datatables.punishment')
            ->editColumn('active', function (BlockedUser $blockeduser)
            {
                if ($blockeduser->active)
                {
                    return '<label class="badge badge-soft-danger">Yes</label>';
                }

                return '<label class="badge badge-soft-info">No</label>';
            })
            ->editColumn('Type', function (BlockedUser $blockeduser)
            {
                return '<button class="btn btn-sm ' . config('constants.punishment_type.' . $blockeduser->Type . '.class') . '"> ' . config('constants.punishment_type.' . $blockeduser->Type . '.text') . '</button>';
            })
            ->editColumn('timeBegin', function (BlockedUser $blockeduser)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $blockeduser->timeBegin->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $blockeduser->timeBegin . '</div>';
            })
            ->editColumn('timeEnd', function (BlockedUser $blockeduser)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $blockeduser->timeEnd->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $blockeduser->timeEnd . '</div>';
            })
            ->rawColumns(['actions', 'active', 'user', 'Type', 'punishment', 'timeBegin', 'timeEnd']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UserBansDataTable $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BlockedUser $model)
    {
        return $model->with(['user', 'punishment'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('userbans-datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white table-sm'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 20, 50, 100, 250, 500, 1000])
            ->pageLength(20)
            ->orderBy(0)
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
            Column::make('id'),
            Column::make('user', 'userID')->footer('<select id="user_select" class="custom-select user_select2"><option></option></select>'),
            Column::computed('active'),
            Column::make('punishment_reason', 'punishment.Description')->title('Reason'),
            Column::make('Type')->footer('<select id="type_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Login</option><option value="2">Login (Inspection)</option><option value="3">P2P Trade</option><option value="4">Chat</option></select>'),
            Column::make('punishment', 'punishment.Executor')->title('Banned By')->footer('<select id="punisher_user_select" class="custom-select user_select2"><option></option></select>'),
            Column::make('timeBegin'),
            Column::make('timeEnd'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(20)
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
        return 'UserBans_' . date('YmdHis');
    }
}
