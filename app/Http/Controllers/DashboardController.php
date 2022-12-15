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
        // $patients = Patient::all();
        $user = auth()->user();

        $user_id = $user->id;

        $patients = User::find($user_id)->patients;

        $therapySessions = TherapySession::where('user_id', $user->id)->get();
        $therapists = User::where('admin', 0)->get();



// TODO: FIX THIS : MAKE SURE TO RETURN PROPER SESSIONS TO PATIENTS
        $id = $therapySession->patient_id;
        $patient = Patient::find($id);



        $allpatients = Patient::all();
        $allClients = Client::all();


        if ($user->admin)

            // return view('dashboard_admin', ['therapists' => $therapists, 'user' => $user]);
            return view('dashboard_admin', ['user' => $user, 'therapists' => $therapists, 'allClients' => $allClients]);
        else
            // return view('dashboard', ['therapysessions' => $therapysessions, 'user' => $user]);
            return view('dashboard', ['user' => $user, 'patients' => $patients, 'therapySessions' => $therapySessions]);
    }
}
