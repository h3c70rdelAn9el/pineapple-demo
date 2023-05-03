<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use App\Models\FileUpload;
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

    public function show($id)
    {
        $user = auth()->user();
        $therapist = User::find($id);
        $clients = $therapist->clients()->get();
        $therapySessions = TherapySession::where("client_id", "=", $therapist->id)->get();

        // show the uploaded forms from fileuploadcontroller
        $file_name = FileUpload::find($id);


        return view('therapist.show', ['therapist' => $therapist, 'therapySessions' => $therapySessions, 'clients' => $clients, 'user' => $user, 'file_name' => $file_name]);
    }
}
