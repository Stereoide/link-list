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
        $linksNum = Link::notRead()->notDismissed()->notStarred()->count();
        $links = Link::notRead()->notDismissed()->notStarred()->limit(100)->get();

        return view('pages.links.index')->with(compact('links', 'linksNum'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        $links = Link::read()->get();
        $linksNum = $links->count();

        return view('pages.links.index')->with(compact('links', 'linksNum'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unread()
    {
        $links = Link::notRead()->get();
        $linksNum = $links->count();

        return view('pages.links.index')->with(compact('links', 'linksNum'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dismissed()
    {
        $links = Link::dismissed()->get();
        $linksNum = $links->count();

        return view('pages.links.index')->with(compact('links', 'linksNum'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notDismissed()
    {
        $links = Link::notDismissed()->get();
        $linksNum = $links->count();

        return view('pages.links.index')->with(compact('links', 'linksNum'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function starred()
    {
        $links = Link::starred()->get();
        $linksNum = $links->count();

        return view('pages.links.index')->with(compact('links', 'linksNum'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notStarred()
    {
        $links = Link::notStarred()->get();
        $linksNum = $links->count();

        return view('pages.links.index')->with(compact('links', 'linksNum'));
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function collectLinks()
    {
        return view('pages.links.collect');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function processCollectedLinks(Request $request)
    {
        $urls = $request->input('urls');
        $ignoreOnetabTitles = ($request->has('ignore-onetab-titles') && $request->input('ignore-onetab-titles') === 'true');
        $ignoreUtmTags = ($request->has('ignore-utm-tags') && $request->input('ignore-utm-tags') === 'true');

        $options = [
            'ignoreOnetabTitles' => $ignoreOnetabTitles,
            'ignoreUtmTags' => $ignoreUtmTags,
        ];

        collect(explode("\n", $urls))
            ->map(function($url) { return trim($url); })
            ->each(function($url) use ($options) {
                $url .= "\n";
                $title = null;

                /* Handle OneTab settings */

                if (!$options['ignoreOnetabTitles']) {
                    preg_match('/ \\| (.*)/', $url, $matches);
                    if (isset($matches[1])) {
                        $title = $matches[1];
                    }
                }

                $url = preg_replace('/ \\| .*/', '', $url);

                /* Handle utm_* settings */

                if ($options['ignoreUtmTags']) {
                    foreach (['&', '\\?', ] as $delimiter) {
                        $url = preg_replace('/' . $delimiter . 'utm_.*(\s)/U', '\\1', $url);
                    }
                }

                /* Determine whether this link is already collected */

                $link = Link::where('url', $url)->first();
                if (is_null($link)) {
                    $link = Link::create(['url' => $url, 'title' => $title, ]);
                }
            });

        return redirect(route('links.index'));
    }

    /**
     * @param Link $link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function follow(Link $link)
    {
        $link->read_at = Carbon::now();
        $link->save();

        return redirect($link->url);
    }

    /**
     * @param Link $link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function dismiss(Link $link)
    {
        $link->dismissed_at = Carbon::now();
        $link->save();

        return redirect(route('links.index'));
    }

    /**
     * @param Link $link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function star(Link $link)
    {
        $link->star();

        return redirect(route('links.index'));
    }

    /**
     * @param Link $link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unstar(Link $link)
    {
        $link->removeStar();

        return redirect(route('links.index'));
    }
}
