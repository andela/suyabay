<?php

namespace Suyabay\Http\Controllers;

use Illuminate\Http\Request;
use Suyabay\Episode;
use Suyabay\Channel;

class SearchController extends Controller
{
    /**
     * Perform a search query and return results
     * if any otherwise notify user No results.
     */
    public function getResults(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()
            ->route('home')
            ->with('info', 'Could not find what you searched for');
        }

        if (env('APP_ENV') === 'testing') {
            $results = Episode::where('episode_name', 'LIKE', "%{$query}%")
                            ->orWhere('episode_description', 'LIKE', "%{$query}%")
                            ->get();
        } else {
            $results = Episode::where('episode_name', 'ILIKE', "%{$query}%")
                            ->orWhere('episode_description', 'ILIKE', "%{$query}%")
                            ->get();
        }

        $channels = Channel::all();

        return view('app.pages.search')->with([
            'results' => $results,
            'channels' => $channels,
        ]);
    }
}
