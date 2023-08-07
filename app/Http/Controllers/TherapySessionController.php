<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use App\Notifications\MissedTherapySessions;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Notifications\SessionLimitNotification;
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
        $therapist = User::find($user_id);
        foreach ($therapySessions as $t) {
            $ts[] = $t;
        }
        return view('client.show', ['therapySessions' => $ts, 'therapist' => $therapist]);
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

        // $client = Client::find($request->client_id);
        $client_id = $request->client_id;
        $client = Client::find($client_id);

        if ($client->therapySessions()->count() < $client->max_sessions) {
            $ts = new TherapySession();
            $ts->client_id = $request->client_id;
            $ts->session_cost = $request->session_cost;
            $clientContribution = DB::table('clients')
                ->where('id', $request->client_id)
                ->value('client_contribution');
            $ts->client_contribution = $request->client_contribution;
            $ts->remaining_client_contribution = $clientContribution - $request->session_cost;
            $ts->client_contribution = $request->client_contribution;
            $ts->created_at = $request->created_at;
            $ts->user_id = $user->id;
            $ts->attendance = $request->attendance;
            $ts->save();
            $user_id = $ts->user_id;
            $therapist = User::find($user_id);

            if ($client->therapySessions()->count() === 14) {
                $client->notify(new SessionLimitNotification());
            }

            // Check if the client has missed 3 consecutive sessions
            $consecutiveNoShows = 0;
            foreach ($client->therapySessions()->latest()->take(5)->get() as $session) {
                if ($session->attendance === 'no-show') {
                    $consecutiveNoShows++;
                } else {
                    break; // Reset the counter if attendance is not 'no-show'
                }
            }

            if ($consecutiveNoShows >= 3) {
                $client->notify(new MissedTherapySessions());
            }


            return redirect()
                ->back()
                ->with('success', 'Session added successfully.');
        } else {
            Session::flash('error', 'You have reached the maximum number of sessions for this client.');
            return redirect()
                ->back();
        }
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
