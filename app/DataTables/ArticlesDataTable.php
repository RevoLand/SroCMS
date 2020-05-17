<?php

namespace App\DataTables;

use App\Article;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArticlesDataTable extends DataTable
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
            ->addColumn('action', 'articles.datatables.actions')
            ->editColumn('is_visible', function (Article $article)
            {
                if ($article->is_visible)
                {
                    return '<span class="badge badge-soft-primary">Visible</span>';
                }

                return '<span class="badge badge-soft-danger">Hidden</span>';
            })
            ->editColumn('can_comment_on', function (Article $article)
            {
                if ($article->can_comment_on)
                {
                    return '<label class="badge badge-soft-primary">Yes</label>';
                }

                return '<label class="badge badge-soft-danger">No</label>';
            })
            ->editColumn('user', 'articles.datatables.user')
            ->editColumn('article_categories', 'articles.datatables.categories')
            ->editColumn('article_comments_count', function (Article $article)
            {
                return '<a class="badge badge-soft-success" href="' . route('admin.articles.comments.index', ['article_id' => $article->id]) . '">' . $article->article_comments_count . '</a>';
            })
            ->editColumn('created_at', function (Article $article)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $article->created_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $article->created_at . '</div>';
            })
            ->editColumn('updated_at', function (Article $article)
            {
                return '<div class="text-muted text-wrap" data-toggle="tooltip" title="' . $article->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 2, 'short' => true]) . '">' . $article->updated_at . '</div>';
            })
            ->rawColumns(['action', 'user', 'article_comments_count', 'is_visible',  'can_comment_on', 'article_categories', 'created_at', 'updated_at'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Article $model)
    {
        request()->validate([
            'author_id' => ['sometimes', 'integer'],
        ]);

        return $model->where(function ($query)
        {
            if (request()->filled('author_id'))
            {
                $query->where('author_id', request('author_id'));
            }

            if (request()->filled('category_id'))
            {
                $query->whereHas('articleCategories', function ($q)
                {
                    $q->where('article_category_id', request('category_id'));
                });
            }
        })->with(['user', 'articleCategories'])->withCount('articleComments')->select(['articles.*'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('articles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orders([[5, 'desc'], [7, 'desc']])
            ->dom("<'row mx-1'<'col-sm-12 col-md-6 px-3'l><'col-sm-12 col-md-6 px-3'f>><'table-responsive'tr><'row mx-1 align-items-center justify-content-center justify-content-md-between'<'col-auto mb-2 mb-sm-0'i><'col-auto'p>>")
            ->responsive(true)
            ->parameters([
                'drawCallback' => "function() { $('.pagination').addClass('pagination-sm'); $('.data-table thead').addClass('bg-200'); $('.data-table tbody').addClass('bg-white'); $('.data-table tfoot').addClass('bg-200'); }",
            ])
            ->lengthMenu([10, 25, 50, 100, 250, 500]);
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
            Column::make('title'),
            Column::make('user', 'author_id')->title('Author')->footer('<select id="user_select" class="custom-select user_select2"><option></option></select>'),
            Column::computed('article_comments_count', 'Comments')->sortable(true),
            Column::make('article_categories', 'articleCategories.name')->title('Categories'),
            Column::make('is_visible')->footer('<select id="visible_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Visible</option><option value="0">Hidden</option></select>'),
            Column::make('can_comment_on')->footer('<select id="can_comment_select" class="custom-select custom-select-sm"><option value=""></option><option value="1">Yes</option><option value="0">No</option></select>'),
            Column::make('published_at'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->title('Actions')
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
        return 'Articles_' . date('YmdHis');
    }
}
