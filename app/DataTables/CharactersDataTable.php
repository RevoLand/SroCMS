<?php

namespace App\DataTables;

use App\Character;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CharactersDataTable extends DataTable
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
            ->addColumn('actions', 'characters.datatables.actions')
            ->addColumn('level', function (Character $character)
            {
                if ($character->CurLevel == $character->MaxLevel)
                {
                    return $character->MaxLevel;
                }

                return "{$character->CurLevel}/{$character->MaxLevel}";
            })
            ->addColumn('username', function (Character $character)
            {
                return '<a class="text-reset text-wrap" href="' . route('admin.users.show', $character->user->account->JID) . '">' . $character->user->account->StrUserID . '</a>';
            })
            ->editColumn('RemainGold', function (Character $character)
            {
                return '<div class="text-wrap">' . number_format($character->RemainGold) . '</div>';
            })
            ->editColumn('job', 'characters.datatables.job')
            ->editColumn('guild', 'characters.datatables.guild')
            ->editColumn('Online', function (Character $character)
            {
                if ($character->Online)
                {
                    return '<label class="badge badge-soft-primary">Yes</label>';
                }

                return '<label class="badge badge-soft-danger">No</label>';
            })
            ->editColumn('LastLogout', function (Character $character)
            {
                if (!isset($character->LastLogout))
                {
                    return '';
                }

                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $character->LastLogout->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $character->LastLogout . '</div>';
            })
            ->setRowId('CharID')
            ->setRowClass('btn-reveal-trigger')
            ->rawColumns(['actions', 'level', 'guild', 'username', 'LastLogout', 'Online', 'job', 'RemainGold']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Character $model)
    {
        return $model->ignoreDummy()->with(['guild:ID,Name,Lvl', 'user.account:JID,StrUserID,Name', 'job'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('characters-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200 text-900'); $('.data-table tbody').addClass('bg-white table-sm'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 20, 50, 100, 250, 500, 1000])
            ->pageLength(20)
            ->orderBy(0, 'asc')
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
            Column::make('CharID'),
            Column::make('CharName16')->title('Character Name'),
            Column::make('NickName16')->title('Job Name'),
            Column::computed('username')->title('Account'),
            Column::make('RemainGold')->title('Gold'),
            Column::make('level', 'CurLevel')->title('Level'),
            Column::make('Strength')->title('Str'),
            Column::make('Intellect')->title('Int'),
            Column::make('guild', 'guild.Name'),
            Column::computed('job'),
            Column::make('LastLogout')->title('Last Logout'),
            Column::make('Online'),
            Column::computed('actions')
                ->exportable(false)
                ->printable(false)
                ->width(20)
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
        return 'Characters_' . date('YmdHis');
    }
}
