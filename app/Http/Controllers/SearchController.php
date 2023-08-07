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
        $query = $request->get('query');
        $results = null;

        if ($query) {
            if ($user->admin === 1) {
                $clientResults = Client::search($query)->get();
                $userResults = User::search($query)->get();
            } else {
                $clientResults = $user->clients()->where('preferred_name', 'like', "%{$query}%")->get();
                $userResults = collect();
            }

            $results = $clientResults->merge($userResults);
        }

        return view('search', [
            'results' => $results,
            'query' => $query,
            'user' => $user
        ]);
    }
}
