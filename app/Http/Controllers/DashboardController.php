<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();

        // $therapysessions = TherapySession::where('user_id', $user->id)->get();
        // $therapists = User::where('admin', 0)->get();

        if ($user->admin)
            // return view('dashboard_admin', ['therapists' => $therapists, 'user' => $user]);
            return view('dashboard_admin');
        else
            // return view('dashboard', ['therapysessions' => $therapysessions, 'user' => $user]);
            return view('dashboard', ['user' => $user, 'patients' => '$patients']);
    }
}
