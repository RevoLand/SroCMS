<?php

namespace App\DataTables;

use App\ArticleComment;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArticleCommentsDataTable extends DataTable
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
            ->addColumn('action', 'articles.comments.datatables.actions')
            ->addColumn('approvedComments', function ($comment)
            {
                return $comment->user->articleComments->count();
            })
            ->editColumn('article', function ($comment)
            {
                return '<a href="' . route('admin.articles.comments.index', ['article_id' => $comment->article_id, 'user_id' => request('user_id')]) . '">' . $comment->article->title . '</a>';
            })
            ->editColumn('user', 'articles.comments.datatables.user')
            ->editColumn('is_visible', function ($comment)
            {
                if ($comment->is_visible)
                {
                    return '<label class="badge badge-soft-primary">Visible</label>';
                }

                return '<label class="badge badge-soft-danger">Hidden</label>';
            })
            ->editColumn('is_approved', function ($comment)
            {
                if ($comment->is_approved)
                {
                    return '<label class="badge badge-soft-primary">Approved</label>';
                }

                return '<label class="badge badge-soft-danger">Not Approved</label>';
            })
            ->setRowId('id')
            ->rawColumns(['article', 'user', 'is_visible', 'is_approved', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ArticleComment $model)
    {
        return $model->with(['article', 'user.articleComments' => function ($query)
        {
            $query->visible()->approved();
        }, ])
            ->where(function ($query)
            {
                if (request()->filled('user_id'))
                {
                    $query->where('user_id', request('user_id'));
                }
                if (request()->filled('article_id'))
                {
                    $query->where('article_id', request('article_id'));
                }

                if (request()->filled('is_visible'))
                {
                    $query->where('is_visible', request('is_visible'));
                }

                if (request()->filled('is_approved'))
                {
                    $query->where('is_approved', request('is_approved'));
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
            ->setTableId('articlecomments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(7)
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500])
            ->rowGroupDataSrc(['article']);
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
            Column::make('article', 'article.title')->title('Article'),
            Column::make('user', 'user_id')->title('User')->footer('<select id="user_select" class="custom-select user_select2"><option></option></select>'),
            Column::computed('approvedComments')->title('Approved Comments')->width(50),
            Column::make('content')->width(800),
            Column::make('is_visible')->footer('<select id="is_visible_select" class="custom-select custom-select-sm"><option selected></option><option value="1">Visible</option><option value="0">Hidden</option></select>'),
            Column::make('is_approved')->footer('<select id="is_approved_select" class="custom-select custom-select-sm"><option selected></option><option value="1">Yes</option><option value="0">No</option></select>'),
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
        return 'ArticleComments_' . date('YmdHis');
    }
}
