<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VoteLogsDataTable;
use App\Http\Controllers\Controller;
use App\VoteLog;

class VoteLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VoteLogsDataTable $dataTable)
    {
        return $dataTable->render('votes.index');
    }

    public function toggleActive(VoteLog $votelog)
    {
        $votelog->update(['active' => !$votelog->active]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Vote state has been successfully updated.',
            'type' => 'success',
        ]);
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
}
