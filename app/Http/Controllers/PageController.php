<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(Request $request)
    {
        $page = Page::whereSlug($request->page)->first();

        if (isset($page->middleware))
        {
            $this->middleware($page->middleware);
        }
    }

    // TODO: Sayfa listesi gibi bir şey olmalı mı olmamalı mı?
    public function index()
    {
    }

    public function show(Page $page)
    {
        if (!$page->enabled)
        {
            return redirect()->route('home');
        }

        if (isset($page->view))
        {
            return view('pages.' . $page->view, compact('page'));
        }

        return view('pages.default', compact('page'));
    }
}
