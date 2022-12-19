<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
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
    public function store(Request $request)
    {
        // TODO: MAKE A THE REQEUST FORM

        $user = auth()->user();

        $ts = new TherapySession();
        $ts->client_id = $request->client_id;
        $ts->total_bill = $request->total_bill;
        $ts->covered_cost = $request->covered_cost;
        $ts->created_at = $request->created_at;
        $ts->user_id = $user->id;
        $ts->save();

        // $client = Client::find($request->client_id);
        $client_id = $request->client_id;
        $client = Client::find($client_id);

        $user_id = $ts->user_id;
        $therapist = User::find($user_id);

        return view('session.show', ['therapySession' => $ts, 'client' => $client, 'therapist' => $therapist]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TherapySession  $therapySession
     * @return \Illuminate\Http\Response
     */
    public function show(TherapySession $therapySession, Client $client, $id)
    {
        $user = auth()->user();

        $therapySession = TherapySession::find($id);
        $client_id = $therapySession->client_id;
        $client = Client::find($client_id);

        $user_id = $therapySession->user_id;
        $therapist = User::find($user_id);

        return view('session.show', ['therapySession' => $therapySession, 'client' => $client, 'therapist' => $therapist, 'user' => $user]);
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
