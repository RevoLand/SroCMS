<?php

namespace App\DataTables;

use App\Guild;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GuildsDataTable extends DataTable
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
            ->addColumn('actions', function (Guild $guild)
            {
                return '<a href="' . route('admin.guilds.show', $guild) . '" class="btn btn-sm btn-falcon-primary"><span class="fas fa-eye fs--1"></span> View</a>';
            })
            ->setRowId('ID')
            ->editColumn('FoundationDate', function (Guild $guild)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $guild->FoundationDate->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 3, 'short' => false]) . '">' . $guild->FoundationDate . '</div>';
            })
            ->editColumn('siegeFortress', function (Guild $guild)
            {
                if (!$guild->siegeFortress)
                {
                    return '-';
                }

                return config('constants.siege.names.' . $guild->siegeFortress->FortressID);
            })
            ->rawColumns(['actions', 'FoundationDate']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Guild $model)
    {
        return $model->with(['siegeFortress'])->withCount('members')->ignoreDummy()->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('guilds-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200 text-900'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
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
            Column::make('ID'),
            Column::make('Name'),
            Column::make('members_count')->title('Member Count')->searchable(false),
            Column::make('GatheredSP')->title('Gathered SP'),
            Column::make('Gold'),
            Column::make('siegeFortress', 'siegeFortress.FortressID')->title('Fortress'),
            Column::make('FoundationDate'),
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
        return 'Guilds_' . date('YmdHis');
    }
}
