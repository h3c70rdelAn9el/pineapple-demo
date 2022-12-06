<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use App\Http\Requests\StoreTherapySessionRequest;
use App\Http\Requests\UpdateTherapySessionRequest;

class TherapySessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $therapySessions = TherapySession::get();
        $ts = [];
        foreach ($therapySessions as $t) {
            $ts[] = $t;
        }
        return view('patient.show', ['therapySessions' => $ts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTherapySessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Patient $patient)
    {
        // TODO: GET IT TO WORK WITH THE REQEUST FORM
        // public function store(StoreTherapySessionRequest $request)
        $user = $request->user();

        $ts = new TherapySession();
        $ts->patient_id = $request->patient_id;
        $ts->total_bill = $request->total_bill;
        $ts->covered_cost = $request->covered_cost;
        $ts->user_id = $user->id;
        $ts->save();

        $id = $request->patient_id;
        $patient = Patient::find($id);

        return view('patient')->with(['patient' => $patient]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TherapySession  $therapySession
     * @return \Illuminate\Http\Response
     */
    public function show($id, Patient $patient)
    {
        // $therapySession = User::find($id);
        $therapySession = TherapySession::find($id);
        $patient = Patient::find($id);
        // dd($therapySession);
        // $ts = $therapySession;

        //TODO:  NOT RETURNING PROPER PATIENT INFO:
        // dd($patient);
        return view('session.show', ['therapySession' => $therapySession, 'patient' => $patient]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TherapySession  $therapySession
     * @return \Illuminate\Http\Response
     */
    public function edit(TherapySession $therapySession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTherapySessionRequest  $request
     * @param  \App\Models\TherapySession  $therapySession
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTherapySessionRequest $request, TherapySession $therapySession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TherapySession  $therapySession
     * @return \Illuminate\Http\Response
     */
    public function destroy(TherapySession $therapySession)
    {
        //
    }
}
