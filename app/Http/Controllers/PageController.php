<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(Request $request)
    {
        if (!$request->has('slug'))
        {
            return;
        }

        $page = Page::findBySlugOrFail($request->slug);

        if (isset($page->middleware))
        {
            $this->middleware($page->middleware);
        }
    }

    // TODO: Sayfa listesi gibi bir şey olmalı mı olmamalı mı?
    public function index()
    {
    }

    public function show($slug)
    {
        $page = Page::findBySlugOrFail($slug);

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
