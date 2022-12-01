<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        // $id = user->user_id;
        // $therapist = User::where('id', $user->id)->first();

        // $therapist = User::where('admin', 0)->get();
        $therapist = User::find($id);
        // TODO: fix this route!
        $therapySessions = TherapySession::where('');

        // return view('therapist.show')->with(['user' => $user, 'therapist' => $therapist, 'therapySessions' => $therapySessions]);
        return view('therapist.show', ['user' => $user, 'therapist' => $therapist, 'therapySessions' => $therapySessions]);

    }
}
