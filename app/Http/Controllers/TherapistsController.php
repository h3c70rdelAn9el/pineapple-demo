<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TherapySession;

class TherapistsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $therapists = User::where('admin', 0)->get();
        return view('therapist.index')->with(['therapists' => $therapists]);
    }

    // public function show(User $user, TherapySession $therapySession, $id, Client $client)
    public function show($id)
    {
        // $user = auth()->user($id);
        $therapist = User::find($id);

        // $user_id = User::find($id);
        // TODO:  RETURN PROPER PATIENTS FOR THERAPIST
        // $clients = Client::all();

        // client_id ->user->user_id
        // $clients = Client::where('user_id');
        $clients = $therapist->clients()->get();

        // $clients = Client::where('user_id')->get();

        //   foreach ($clients as $client) {
        //     $clients[] = ['id' => $client->id, 'chosen_name' => $client->chosen_name];
        // }
        $therapySessions = TherapySession::where('');


        // dd($clients);

        return view('therapist.show', ['therapist' => $therapist, 'therapySessions' => $therapySessions, 'clients' => $clients]);
    }
}
