<?php

namespace App\DataTables;

use App\Article;
use Yajra\DataTables\Html\Button;
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
            ->editColumn('is_visible', function ($article)
            {
                if ($article->is_visible)
                {
                    return '<label class="badge badge-primary">Visible</label>';
                }

                return '<label class="badge badge-danger">Hidden</label>';
            })
            ->editColumn('can_comment_on', function ($article)
            {
                if ($article->can_comment_on)
                {
                    return '<label class="badge badge-primary">Yes</label>';
                }

                return '<label class="badge badge-danger">No</label>';
            })
            ->editColumn('user', 'articles.datatables.user')
            ->editColumn('article_categories', 'articles.datatables.categories')
            ->editColumn('article_comments_count', function ($article)
            {
                return '<a class="badge" href="' . route('admin.articles.comments.index', ['article_id' => $article->id]) . '">' . $article->article_comments_count . '</a>';
            })
            ->rawColumns(['action', 'user', 'article_comments_count', 'is_visible',  'can_comment_on', 'article_categories'])
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
        })->with(['user', 'articleCategories'])->withCount('articleComments')->newQuery();
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
            ->dom("<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\t\t\t<'row'<'col-sm-12'tr>>\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>")
            ->orders([[5, 'desc'], [7, 'desc']])
            ->pagingType('first_last_numbers')
            ->lengthMenu([10, 25, 50, 100, 250, 500])
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
            Column::make('title'),
            Column::computed('user')->title('Author'),
            Column::computed('article_comments_count', 'Comments')->sortable(true),
            Column::make('article_categories', 'articleCategories.name')->title('Categories'),
            Column::make('is_visible'),
            Column::make('can_comment_on'),
            Column::make('published_at'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->title('Actions')
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
        return 'Articles_' . date('YmdHis');
    }
}
