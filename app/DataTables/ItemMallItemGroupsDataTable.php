<?php

namespace App\DataTables;

use App\ItemMallItemGroup;
use DB;
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
            ->editColumn('enabled', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->enabled)
                {
                    return '<label class="badge badge-soft-primary">Enabled</label>';
                }

                return '<label class="badge badge-soft-danger">Disabled</label>';
            })
            ->editColumn('on_sale', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->on_sale)
                {
                    return '<label class="badge badge-soft-primary">Yes</label>';
                }

                return '<label class="badge badge-soft-danger">No</label>';
            })
            ->editColumn('featured', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->featured)
                {
                    return '<label class="badge badge-soft-primary">Yes</label>';
                }

                return '<label class="badge badge-soft-danger">No</label>';
            })
            ->editColumn('limit_total_purchases', function (ItemMallItemGroup $itemgroup)
            {
                if ($itemgroup->limit_total_purchases)
                {
                    return '<label class="badge badge-soft-primary">Yes</label>';
                }

                return '<label class="badge badge-soft-danger">No</label>';
            })
            ->editColumn('payment_type', function (ItemMallItemGroup $itemgroup)
            {
                return '<label class="badge badge-soft-info">' . config('constants.payment_types.' . $itemgroup->payment_type) . '</label>';
            })
            ->editColumn('available_after', function (ItemMallItemGroup $itemgroup)
            {
                return '<div class="text-muted text-wrap">' . $itemgroup->available_after . '</div>';
            })
            ->editColumn('available_until', function (ItemMallItemGroup $itemgroup)
            {
                return '<div class="text-muted text-wrap">' . $itemgroup->available_until . '</div>';
            })
            ->editColumn('created_at', function (ItemMallItemGroup $itemgroup)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $itemgroup->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $itemgroup->created_at . '</div>';
            })
            ->editColumn('updated_at', function (ItemMallItemGroup $itemgroup)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $itemgroup->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $itemgroup->updated_at . '</div>';
            })
            ->rawColumns(['action', 'categories', 'enabled', 'on_sale', 'featured', 'limit_total_purchases', 'payment_type', 'available_after', 'available_until', 'created_at', 'updated_at'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ItemMallItemGroup $model)
    {
        return $model->with('categories')->withCount(['orders' => function ($orderq)
        {
            $orderq->select(DB::raw('SUM(quantity)'));
        }, ])->newQuery();
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
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200 text-900'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->orderBy(15);
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
            Column::make('payment_type')->footer('<select id="payment_type_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Balance</option><option value="2">Balance (Point)</option><option value="3">Silk</option><option value="4">Silk (Gift)</option><option value="5">Silk (Point)</option><option value="6">Item</option></select>'),
            Column::make('price'),
            Column::make('price_before'),
            Column::make('on_sale')->footer('<select id="on_sale_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>'),
            Column::make('featured')->footer('<select id="featured_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>'),
            Column::make('limit_total_purchases')->footer('<select id="limit_total_purchases_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>'),
            Column::make('total_purchase_limit'),
            Column::make('orders_count')->title('Total Purchases')->searchable(false),
            Column::make('enabled')->footer('<select id="enabled_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>'),
            Column::make('available_after'),
            Column::make('available_until'),
            Column::make('created_at')->hidden(),
            Column::make('updated_at')->hidden(),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(40)
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
