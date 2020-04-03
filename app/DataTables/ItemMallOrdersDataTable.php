<?php

namespace App\DataTables;

use App\ItemMallOrder;
use Yajra\DataTables\Html\Button;
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
            ->setRowId('id')
            ->rawColumns(['action', 'items', 'user']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ItemMallOrder $model)
    {
        return $model->with(['items' => function ($query)
        {
            if (request()->has('payment_type'))
            {
                $query->where('payment_type', request('payment_type'));
            }

            if (request()->has('item_group_id'))
            {
                $query->where('item_mall_item_group_id', request('item_group_id'));
            }
        }, 'items.itemgroup', 'user', ])->where(function ($query)
        {
            if (request()->has('user_id'))
            {
                $query->where('user_id', request('user_id'));
            }
        })->whereHas('items')->newQuery();
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
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orderBy(4)
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
            Column::make('user', 'user_id'),
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
