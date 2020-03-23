<?php

namespace App\DataTables;

use App\ItemMallItemGroup;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ItemMallItemGroupsDataTable extends DataTable
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
            ->addColumn('action', 'itemmall.itemgroups.datatables.actions')
            ->addColumn('categories', 'itemmall.itemgroups.datatables.categories')
            ->editColumn('orders', function (ItemMallItemGroup $itemgroup)
            {
                return $itemgroup->totalOrders;
            })
            ->editColumn('enabled', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->enabled)
                {
                    return '<label class="badge badge-primary">Enabled</label>';
                }

                return '<label class="badge badge-danger">Disabled</label>';
            })
            ->editColumn('on_sale', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->on_sale)
                {
                    return '<label class="badge badge-primary">Yes</label>';
                }

                return '<label class="badge badge-danger">No</label>';
            })
            ->editColumn('featured', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->featured)
                {
                    return '<label class="badge badge-primary">Yes</label>';
                }

                return '<label class="badge badge-danger">No</label>';
            })
            ->editColumn('limit_total_purchases', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->limit_total_purchases)
                {
                    return '<label class="badge badge-primary">Yes</label>';
                }

                return '<label class="badge badge-danger">No</label>';
            })
            ->editColumn('payment_type', function (ItemMallItemGroup $itemgroup)
            {
                return '<label class="badge badge-info">' . config('constants.payment_types.' . $itemgroup->payment_type) . '</label>';
            })
            ->rawColumns(['action', 'categories', 'enabled', 'on_sale', 'featured', 'limit_total_purchases', 'payment_type'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ItemMallItemGroup $model)
    {
        return $model->with(['categories', 'orders'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('itemmallitemgroups-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orderBy(15)
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
            Column::make('name'),
            Column::make('categories', 'categories.name'),
            Column::make('payment_type'),
            Column::make('price'),
            Column::make('price_before'),
            Column::make('on_sale'),
            Column::make('featured'),
            Column::make('limit_total_purchases'),
            Column::make('total_purchase_limit'),
            Column::computed('orders')->title('Total Purchases'),
            Column::make('enabled'),
            Column::make('available_after'),
            Column::make('available_until'),
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
        return 'ItemMallItemGroups_' . date('YmdHis');
    }
}
