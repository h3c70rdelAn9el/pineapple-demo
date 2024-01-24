<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Notifications\MissedTherapySessions;
use App\Notifications\SessionLimitNotification;
use App\Http\Requests\StoreTherapySessionRequest;
use App\Http\Requests\UpdateTherapySessionRequest;
use App\Notifications\SpecialSessionsLimitNotification;
// use Log
use Illuminate\Support\Facades\Log;

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
        $user = auth()->user();
        $client_id = $request->client_id;
        $client = Client::find($client_id);

        if ($user->admin == 1) {
            $therapist = $client->user;
        } else {
            $therapist = User::find($user->id);
        }

        if ($therapist->session_cost == null || $therapist->session_cost == 0) {
            Session::flash('error', 'You have no session cost set. Please set it in your profile.');
            return redirect()->back();
        }

        $therapist_session_cost = $therapist->session_cost;

        if ($client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count() < $client->max_sessions) {

            $specialSessionsCount = $client->therapySessions()->where('special', true)->count();

            if ($client->special_sessions && $specialSessionsCount < 6) {
                // Special session
                $ts = new TherapySession();
                $ts->client_id = $request->client_id;
                $ts->session_cost = 0;
                $ts->client_contribution = $request->client_contribution;
                $ts->remaining_client_contribution = $client->client_contribution - $ts->session_cost;
                $ts->created_at = $request->created_at;
                $ts->user_id = $user->id;
                $ts->attendance = $request->attendance;
                $ts->notes = $request->notes;
                $ts->special = true;

                $ts->save();
            } else {
                // Regular session
                $ts = new TherapySession();
                $ts->client_id = $request->client_id;
                $ts->session_cost = $therapist_session_cost;
                $ts->client_contribution = $request->client_contribution;
                $ts->remaining_client_contribution = $client->client_contribution - $ts->session_cost;
                $ts->created_at = $request->created_at;
                $ts->user_id = $user->id;
                $ts->attendance = $request->attendance;
                $ts->notes = $request->notes;

                $ts->save();
            }

            if ($client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count() >= 16) {
                $client->status = 1;
                $client->save();
            } else {
                $client->status = 0;
                $client->save();
            }

            $user_id = $ts->user_id;
            $therapist = User::find($user_id);

            if ($client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count() === 14) {
                $client->notify(new SessionLimitNotification());
            }

                if ($client->special_sessions == 0) {
       
                     $therapist->notify(new SpecialSessionsLimitNotification());
                }


            $consecutiveNoShows = 0;
            foreach ($client->therapySessions()->latest()->take(5)->get() as $session) {
                if ($session->attendance === 'no-show') {
                    $consecutiveNoShows++;
                } else {
                    break;
                }
            }

            if ($consecutiveNoShows >= 3) {
                $client->notify(new MissedTherapySessions());
            }

            return redirect()->back()->with('success', 'Session added successfully.');
        } else {
            Session::flash('error', 'You have reached the maximum number of sessions for this client.');
            return redirect()->back();
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

        $attendedSessions = $client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->get();

        $user_id = $therapySession->user_id;
        $therapist = User::find($user_id);

        $attendanceColor = $this->calculateAttendanceColor($therapySession->attendance);


        $defaultSpecialSessions = $client->special_sessions ?: 6;
        $specialSessionsCount = $client->therapySessions()->where('special', true)->count();
        $specialSessionsLeft = max(0, $defaultSpecialSessions - $specialSessionsCount);



        return view('session.show', ['therapySession' => $therapySession, 'client' => $client, 'therapist' => $therapist, 'user' => $user, 'attendedSessions' => $attendedSessions, 'attendanceColor' => $attendanceColor, 'specialSessionsLeft' => $specialSessionsLeft, 'defaultSpecialSessions' => $defaultSpecialSessions, 'defaultSpecialSessions' => $defaultSpecialSessions]);
    }

    private function calculateAttendanceColor($attendance)
    {
        if ($attendance === 'attended') {
            return 'green-500';
        } elseif ($attendance === 'no-show') {
            return 'yellow-500';
        } else {
            return 'text-gray-800';
        }
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
