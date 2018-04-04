<?php

namespace App\Http\Controllers;

use App\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Link::notDismissed()->get();

        return view('pages.links.index')->with(compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        //
    }

    public function collectLinks()
    {
        return view('pages.links.collect');
    }

    public function processCollectedLinks(Request $request)
    {
        collect(explode("\n", $request->input('urls')))
            ->map(function($url) { return trim($url); })
            ->each(function($url) {
                /* Determine whether this link is already collected */

                $link = Link::where('url', $url)->first();
                if (is_null($link)) {
                    $link = Link::create(['url' => $url]);
                }
            });

        return redirect(route('links.index'));
    }

    public function follow(Link $link)
    {
        $link->read_at = Carbon::now();
        $link->save();

        return redirect($link->url);
    }
}
