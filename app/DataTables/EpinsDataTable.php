<?php

namespace App\DataTables;

use App\Epin;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EpinsDataTable extends DataTable
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
            ->addColumn('action', 'epins.datatables.actions')
            ->editColumn('user.StrUserID', 'epins.datatables.user')
            ->editColumn('creater.StrUserID', 'epins.datatables.creater')
            ->editColumn('type', function (Epin $epin)
            {
                return config('constants.payment_types.' . $epin->type);
            })
            ->editColumn('enabled', function ($page)
            {
                if ($page->enabled)
                {
                    return '<label class="badge badge-primary">Enabled</label>';
                }

                return '<label class="badge badge-danger">Disabled</label>';
            })
            ->setRowClass(function (Epin $epin)
            {
                return $epin->used_at ? 'alert-warning' : 'alert-success';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'enabled', 'user.StrUserID', 'creater.StrUserID']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Epin $model)
    {
        return $model->with(['user', 'creater'])->withCount('items')->where(function ($query)
        {
            if (request()->filled('filter'))
            {
                switch (request('filter'))
                {
                    default:
                    case 1:
                        $query->whereNull('used_at');
                    break;
                    case 2:
                        $query->whereNotNull('used_at');
                    break;
                }
            }

            if (request()->filled('creater_user_id'))
            {
                $query->where('creater_user_id', request('creater_user_id'));
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
            ->setTableId('epins-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orderBy(9)
            ->pagingType('first_last_numbers')
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
            Column::make('code'),
            Column::make('type'),
            Column::make('balance'),
            Column::make('items_count')->searchable(false),
            Column::computed('user.StrUserID')->title('Used by'),
            Column::computed('creater.StrUserID')->title('Created by'),
            Column::make('enabled'),
            Column::make('used_at'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(140)
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
        return 'Epins_' . date('YmdHis');
    }
}
