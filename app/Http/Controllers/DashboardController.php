<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function index(User $user, TherapySession $therapySession)
    {
        $user = auth()->user();
        $user_id = $user->id;

        $clients = User::find($user_id)->clients;
        $client = Client::find($user_id);
        $allClients = Client::all();


        $therapySessions = TherapySession::where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->get();
        $therapists = User::where('admin', 0)->get()->sortBy('name');
        // $therapist = User::find($user_id);
        $therapist = Client::find($user_id)?->therapist;

        // add the client's therapist


        // TODO: FIX THIS RETRIVAL OF STATES
        // add states from states.json file
        // $states = file_get_contents(storage_path('states.json'));
        // $states = $states;
        // dd($states);
        $file = file_get_contents(storage_path('states.json'));
        $states = json_decode($file, true);

        $jsonFile = file_get_contents(resource_path('json/categories.json'));
        $categories = json_decode($jsonFile, true);

        // dd($data);


        if ($user->admin) {
            return view('dashboard_admin', ['user' => $user, 'therapists' => $therapists, 'allClients' => $allClients, 'therapist' => $therapist, 'therapySessions' => '$therapySessions', 'states' => $states, 'categories' => $categories]);
        } else {
            return view('dashboard', ['user' => $user, 'clients' => $clients, 'client' => $client, 'therapySessions' => $therapySessions, 'therapist' => $therapist, 'states' => $states]);
        }
    }
}
