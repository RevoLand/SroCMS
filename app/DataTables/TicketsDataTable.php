<?php

namespace App\DataTables;

use App\Ticket;
use App\TicketCategory;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TicketsDataTable extends DataTable
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
            ->addColumn('actions', function ($ticket)
            {
                return '<a href="' . route('admin.tickets.show', $ticket) . '" class="btn btn-sm btn-falcon-primary"><span class="fas fa-eye fs--1"></span> View</a>';
            })
            ->addColumn('ticketbans', 'tickets.datatables.ticketbans')
            ->editColumn('user', 'tickets.datatables.user')
            ->editColumn('assigned_user', 'tickets.datatables.assignedUser')
            ->editColumn('priority', 'tickets.datatables.priority')
            ->editColumn('status', 'tickets.datatables.status')
            ->editColumn('created_at', function ($ticket)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticket->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticket->created_at . '</div>';
            })
            ->editColumn('updated_at', function ($ticket)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $ticket->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $ticket->updated_at . '</div>';
            })
            ->setRowId('id')
            ->rawColumns(['actions', 'priority', 'status', 'user', 'assigned_user', 'ticketbans', 'created_at', 'updated_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\TicketsDataTable $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Ticket $model)
    {
        return $model->with(['category', 'user' => function ($userq)
        {
            $userq->with('ticketBans', 'activeTicketBans');
        }, 'assignedUser', 'order', ])->withCount('messages')->where(function ($query)
        {
            if (request()->filled('user_id'))
            {
                $validated = request()->validate([
                    'user_id' => ['integer'],
                ]);

                $query->where('user_id', $validated['user_id']);
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
            ->setTableId('tickets-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 20, 50, 100, 250, 500, 1000])
            ->pageLength(20)
            ->pagingType('first_last_numbers')
            ->orders([['6', 'desc'], ['9', 'desc']]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $priority_selector = '<select id="priority_select" class="form-control form-control-sm select2"><option value="" selected>-</option>';
        collect(config('constants.ticket_system.priority'))->map(function ($item, $key)
        {
            return "<option value='{$key}'>{$item['name']}</option>";
        })->each(function ($item) use (&$priority_selector)
        {
            $priority_selector .= $item;
        });
        $priority_selector .= '</select>';

        $status_selector = '<select id="status_select" class="form-control form-control-sm select2"><option value="" selected>-</option>';
        collect(config('constants.ticket_system.status'))->map(function ($item, $key)
        {
            return "<option value='{$key}'>{$item['name']}</option>";
        })->each(function ($item) use (&$status_selector)
        {
            $status_selector .= $item;
        });
        $status_selector .= '</select>';

        $category_selector = '<select id="category_select" class="form-control form-control-sm select2"><option value="" selected>-</option>';
        TicketCategory::enabled()->select(['id', 'name'])->get()->each(function ($item) use (&$category_selector)
        {
            $category_selector .= "<option value='{$item->id}'>{$item->name}</option>";
        });
        $category_selector .= '</select>';

        return [
            Column::make('id'),
            Column::make('title'),
            Column::make('category.name', 'ticket_category_id')->title('Category')->footer($category_selector),
            Column::computed('ticketbans')->title('Ticket Ban(s)'),
            Column::make('messages_count')->searchable(false)->title('Messages')->width(20),
            Column::make('user', 'user_id')->title('User')->footer('<select id="user_select" class="custom-select user_select2"><option></option></select>'),
            Column::make('assigned_user', 'assigned_user_id')->title('Assigned To')->footer('<select id="assigned_user_select" class="custom-select user_select2"><option></option></select>'),
            Column::make('priority')->footer($priority_selector),
            Column::make('status')->footer($status_selector),
            Column::make('created_at')->width(50),
            Column::make('updated_at')->width(50),
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
        return 'Tickets_' . date('YmdHis');
    }
}
