<?php

namespace App\DataTables;

use App\Ticket;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserTicketsDataTable extends DataTable
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
            ->addColumn('actions', 'user.tickets.datatables.actions')
            ->editColumn('priority', 'user.tickets.datatables.priority')
            ->editColumn('status', 'user.tickets.datatables.status')
            ->editColumn('created_at', function (Ticket $ticket)
            {
                return '<div class="text-muted" data-toggle="tooltip" title="' . $ticket->created_at . '">' . $ticket->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '</div>';
            })
            ->editColumn('updated_at', function (Ticket $ticket)
            {
                return '<div class="text-muted" data-toggle="tooltip" title="' . $ticket->updated_at . '">' . $ticket->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '</div>';
            })
            ->setRowId('id')
            ->rawColumns(['actions', 'priority', 'status', 'created_at', 'updated_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return auth()->user()->tickets()->with('category')->withCount('messages')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('usertickets-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(7);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $priority_selector = '<select id="priority_select" class="form-control form-control-sm"><option value="" selected>-</option>';
        collect(config('constants.ticket_system.priority'))->map(function ($item, $key)
        {
            return "<option value='{$key}'>{$item['name']}</option>";
        })->each(function ($item) use (&$priority_selector)
        {
            $priority_selector .= $item;
        });
        $priority_selector .= '</select>';

        $status_selector = '<select id="status_select" class="form-control form-control-sm"><option value="" selected>-</option>';
        collect(config('constants.ticket_system.status'))->map(function ($item, $key)
        {
            return "<option value='{$key}'>{$item['name']}</option>";
        })->each(function ($item) use (&$status_selector)
        {
            $status_selector .= $item;
        });
        $status_selector .= '</select>';

        return [
            Column::make('id')->width(20),
            Column::make('title')->width(140),
            Column::make('category.name', 'category.name')->title('Category')->width(80),
            Column::computed('messages_count', 'Messages')->width(20),
            Column::make('priority')->addClass('text-center')->footer($priority_selector)->width(70),
            Column::make('status')->addClass('text-center')->footer($status_selector)->width(70),
            Column::make('created_at')->addClass('text-center')->width(50),
            Column::make('updated_at')->addClass('text-center')->width(50),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(30)
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
        return 'UserTickets_' . date('YmdHis');
    }
}
