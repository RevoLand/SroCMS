<?php

namespace App\DataTables;

use App\ItemMallCategory;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ItemMallCategoriesDataTable extends DataTable
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
            ->addColumn('action', 'itemmall.categories.datatables.actions')
            ->editColumn('enabled', function (ItemMallCategory $category)
            {
                if ($category->enabled)
                {
                    return '<label class="badge badge-soft-primary">Enabled</label>';
                }

                return '<label class="badge badge-soft-danger">Disabled</label>';
            })
            ->editColumn('created_at', function (ItemMallCategory $category)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $category->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $category->created_at . '</div>';
            })
            ->editColumn('updated_at', function (ItemMallCategory $category)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $category->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $category->updated_at . '</div>';
            })
            ->rawColumns(['action', 'enabled', 'created_at', 'updated_at'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ItemMallCategory $model)
    {
        return $model->withCount('itemGroups')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('itemmallcategories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200 text-900'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->orderBy(3, 'asc');
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
            Column::make('item_groups_count')->title('Item Groups Attached')->searchable(false),
            Column::make('order')->title('List Order'),
            Column::make('enabled'),
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
        return 'ItemMallCategories_' . date('YmdHis');
    }
}
