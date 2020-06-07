<?php

namespace App\DataTables;

use App\Epin;
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
            ->editColumn('user', 'epins.datatables.user')
            ->editColumn('creater', 'epins.datatables.creater')
            ->editColumn('type', function (Epin $epin)
            {
                return config('constants.payment_types.' . $epin->type);
            })
            ->editColumn('enabled', function (Epin $epin)
            {
                if ($epin->enabled)
                {
                    return '<label class="badge badge-soft-primary">Enabled</label>';
                }

                return '<label class="badge badge-soft-danger">Disabled</label>';
            })
            ->setRowClass(function (Epin $epin)
            {
                // return $epin->used_at ? 'alert-soft-warning' : 'alert-soft-success';
            })
            ->editColumn('created_at', function (Epin $epin)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $epin->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $epin->created_at . '</div>';
            })
            ->editColumn('updated_at', function (Epin $epin)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $epin->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $epin->updated_at . '</div>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'enabled', 'user', 'creater', 'created_at', 'updated_at']);
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

            if (request()->filled('user_id'))
            {
                $query->where('user_id', request('user_id'));
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
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200 text-900'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->orderBy(10)
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
            Column::make('code'),
            Column::make('type')->footer('<select id="type_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Balance</option><option value="2">Balance (Point)</option><option value="3">Silk</option><option value="4">Silk (Gift)</option><option value="5">Silk (Point)</option><option value="6">Item</option></select>'),
            Column::make('balance')->title('Amount'),
            Column::make('items_count')->searchable(false),
            Column::make('user', 'user_id')->title('Used by')->footer('<select id="user_select" class="custom-select"><option></option></select>'),
            Column::computed('creater')->title('Created by'),
            Column::make('enabled')->footer('<select id="enabled_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Enabled</option><option value="0">Disabled</option></select>'),
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
