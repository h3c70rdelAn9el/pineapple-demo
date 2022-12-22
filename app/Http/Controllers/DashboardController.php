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

        $therapySessions = TherapySession::where('user_id', $user->id)->get();
        $therapists = User::where('admin', 0)->get();
        $therapist = TherapySession::where("user_id", "=", $user->id)->get();



        $allClients = Client::all();


        if ($user->admin)

            return view('dashboard_admin', ['user' => $user, 'therapists' => $therapists, 'allClients' => $allClients]);
        else
            return view('dashboard', ['user' => $user, 'clients' => $clients, 'therapySessions' => $therapySessions, 'therapist' => $therapist]);
    }
}
