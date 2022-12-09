<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function index(User $user)
    {
        // $patients = Patient::all();
        $user = auth()->user();

        $user_id = $user->id;

        $patients = User::find($user_id)->patients;

        // $therapysessions = TherapySession::where('user_id', $user->id)->get();
        $therapists = User::where('admin', 0)->get();


        $allpatients = Patient::all();
        if ($user->admin)

            // return view('dashboard_admin', ['therapists' => $therapists, 'user' => $user]);
            return view('dashboard_admin', ['user' => $user, 'therapists' => $therapists, 'allpatients' => $allpatients]);
        else
            // return view('dashboard', ['therapysessions' => $therapysessions, 'user' => $user]);
            return view('dashboard', ['user' => $user, 'patients' => $patients]);
    }
}
