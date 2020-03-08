<?php

namespace App\Http\Controllers\Admin;

use App\ArticleComment;
use App\DataTables\ArticleCommentsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleCommentsDataTable $dataTable)
    {
        return $dataTable->render('articles.comments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleComment $comment)
    {
        $comment->load(['user', 'article', 'user.articleComments' => function ($query)
            {
                $query->approved()->visible();
            }, ]);

        return view('articles.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleComment $comment)
    {
        $comment->update($this->validateComment());

        return redirect()->route('admin.articles.comments.edit', $comment)->with('message', 'Comment is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleComment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.articles.comments.index')->with('message', 'Comment is successfully deleted.');
    }

    public function destroyAjax(ArticleComment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment is deleted.']);
    }

    public function toggleApproved(ArticleComment $comment)
    {
        $comment->update([
            'is_approved' => !$comment->is_approved,
        ]);

        return response()->json(['message' => 'Comment Approval state is successfully updated! New state: ' . (($comment->is_approved) ? 'Approved' : 'Not Approved')]);
    }

    public function toggleVisibility(ArticleComment $comment)
    {
        $comment->update([
            'is_visible' => !$comment->is_visible,
        ]);

        return response()->json(['message' => 'Comment Visibility is successfully updated! New Visibility setting is: ' . (($comment->is_visible) ? 'Visible' : 'Not Visible')]);
    }

    private function validateComment()
    {
        return request()->validate([
            'content' => ['required', 'string'],
            'is_visible' => ['required', 'boolean'],
            'is_approved' => ['required', 'boolean'],
        ]);
    }
}
