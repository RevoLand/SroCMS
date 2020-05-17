<?php

namespace App\DataTables;

use App\ItemMallOrder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ItemMallOrdersDataTable extends DataTable
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
            ->addColumn('action', 'itemmall.datatables.actions')
            ->editColumn('items', 'itemmall.datatables.items')
            ->editColumn('user', 'itemmall.datatables.user')
            ->editColumn('created_at', function (ItemMallOrder $itemmallorder)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $itemmallorder->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $itemmallorder->created_at . '</div>';
            })
            ->editColumn('updated_at', function (ItemMallOrder $itemmallorder)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $itemmallorder->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $itemmallorder->updated_at . '</div>';
            })
            ->setRowId('id')
            ->rawColumns(['action', 'items', 'user', 'created_at', 'updated_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ItemMallOrder $model)
    {
        return $model->with(['items', 'items.itemgroup', 'user'])
            ->where(function ($query)
            {
                if (request()->has('user_id'))
                {
                    $query->where('user_id', request('user_id'));
                }
            })->whereHas('items', function ($query)
            {
                if (request()->has('payment_type'))
                {
                    $query->where('payment_type', request('payment_type'));
                }

                if (request()->has('item_group_id'))
                {
                    $query->where('item_mall_item_group_id', request('item_group_id'));
                }
            })->select(['item_mall_orders.*'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('itemmallorders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->orderBy(4);
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
            Column::make('user', 'user_id')->footer('<select id="user_select" class="custom-select user_select2"><option></option></select>'),
            Column::make('items', 'items.itemgroup.name'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
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
        return 'ItemMallOrders_' . date('YmdHis');
    }
}
