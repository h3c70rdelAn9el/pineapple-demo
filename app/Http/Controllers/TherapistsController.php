<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function show(User $user, TherapySession $therapySession, $id)
    {
        $user = auth()->user();
        $therapist = User::find($id);
        // TODO:  RETURN PROPER PATIENTS FOR THERAPIST
        $patients = Patient::all();
        $therapySessions = TherapySession::where('');

        return view('therapist.show', ['user' => $user, 'therapist' => $therapist, 'therapySessions' => $therapySessions, 'patients' => $patients]);
    }
}
