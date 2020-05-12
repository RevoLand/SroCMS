<?php

namespace App\DataTables;

use App\TicketCategory;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TicketCategoriesDataTable extends DataTable
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
            ->addColumn('actions', 'tickets.categories.datatables.actions')
            ->editColumn('enabled', function ($category)
            {
                if ($category->enabled)
                {
                    return '<label class="badge badge-soft-primary">Enabled</label>';
                }

                return '<label class="badge badge-soft-danger">Disabled</label>';
            })
            ->setRowId('id')
            ->rawColumns(['actions', 'enabled']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\TicketCategoriesDataTable $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TicketCategory $model)
    {
        return $model->withCount('tickets')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('ticketcategories-datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->pagingType('first_last_numbers')
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
            Column::make('name'),
            Column::make('tickets_count')->searchable(false),
            Column::make('enabled'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('actions')
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
        return 'TicketCategories_' . date('YmdHis');
    }
}
