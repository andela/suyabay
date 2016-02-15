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
        //Get what user has typed in the search query
        $query = $request->input('query');

        //for testing use LIKE since ILIKE is not recognised as a query in sqlite
        $condition = env('APP_ENV') == 'testing' ? 'LIKE' : 'ILIKE';

        //fetch results based on the query terms. Will look into the episode model
        $results = Episode::where('episode_name', $condition, "%{$query}%")
                          ->orWhere('episode_description', $condition, "%{$query}%")
                          ->get();

        return view('app.pages.search')->with([
            'results' => $results,
            'channels' => Channel::all(),
        ]);
    }
}
