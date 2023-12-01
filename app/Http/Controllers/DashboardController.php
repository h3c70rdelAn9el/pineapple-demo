<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
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
        // $clients = User::find($user_id)->clients()->orderBy('preferred_name')->get();
        $clients = User::find($user_id)->clients()->orderBy('client_code', 'asc')->get();

        $client = Client::find($user_id);
        $allClients = Client::all()->sortBy('client_code');
        $activeClients = Client::where('status', '0')->get()->sortBy('client_code');
        $inactiveClients = Client::where('status', '1')->get()->sortBy('client_code');
        $therapySessions = TherapySession::where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->get();
        $therapists = User::where('admin', 0)->get()->sortBy('name');
        // $therapist = User::find($user_id);
        $therapist = Client::find($user_id)?->therapist;
        $attendedSessions = TherapySession::whereIn('client_id', $clients->pluck('id'))->whereIn('attendance', ['attended', 'no-show'])->get();

        $inactiveTherapists = User::where('admin', 0)->where('active_status', 1)->get();
        $activeTherapists = User::where('admin', 0)->where('active_status', 0)->get();

        $file = file_get_contents(storage_path('states.json'));
        $states = json_decode($file, true);

        $jsonFile = file_get_contents(resource_path('json/categories.json'));
        $categories = json_decode($jsonFile, true);

        if ($user->admin) {
            return view('dashboard_admin', ['user' => $user, 'therapists' => $therapists, 'allClients' => $allClients, 'therapist' => $therapist, 'therapySessions' => '$therapySessions', 'states' => $states, 'categories' => $categories, 'activeClients' => $activeClients, 'inactiveClients' => $inactiveClients, 'attendedSessions' => $attendedSessions, 'inactiveTherapists' => $inactiveTherapists, 'activeTherapists' => $activeTherapists]);
        } else {
            return view('dashboard', ['user' => $user, 'clients' => $clients, 'client' => $client, 'therapySessions' => $therapySessions, 'therapist' => $therapist, 'states' => $states, 'categories' => $categories, 'activeClients' => $activeClients, 'inactiveClients' => $inactiveClients]);
        }
    }
}
