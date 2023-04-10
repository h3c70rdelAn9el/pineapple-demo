<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        // add the user
        $user = auth()->user();


        $results = null;


        // if ($query = $request->get('query')) {
        //     $results = Client::search($query)->get();
        // }

        if ($query = $request->get('query')) {
            $clientResults = Client::search($query)->get();
            $userResults = User::search($query)->get();
            $results = $clientResults->merge($userResults);
        }



        // return view('search', [
        //     'results' => $results,
        // ]);

        return view('search', [
            'results' => $results,
            'query' => $query,
            'user' => $user
        ]);
    }
}
