<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTherapySessionRequest;
use App\Mail\ClientMissedOneSession;
use App\Mail\ClientMissedThreeSessions;
use App\Mail\ClientMissedTwoSessions;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use App\Notifications\MissedTherapySessions;
use App\Notifications\SessionLimitNotification;
use App\Notifications\SpecialSessionsLimitNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TherapySessionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $userId = $user->id;

        $therapySessions = TherapySession::where('user_id', $userId)
            ->with(['client', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(100, ['*'], 'therapy_sessions');

        $therapist = User::find($userId);
        $therapists = User::where('admin', '!=', 1)->get();
        $clients = Client::all();

        $missedSessions = TherapySession::where('user_id', $userId)->where('attendance', 'no-show')
            ->orderBy('created_at', 'desc')->paginate(100, ['*'], 'missed_sessions');
        $specialSessions = TherapySession::where('user_id', $userId)->where('special', 1)
            ->orderBy('created_at', 'desc')->paginate(100, ['*'], 'special_sessions');

        $allTherapySessions = TherapySession::with(['client', 'user'])
            ->orderBy('created_at', 'desc')->paginate(100, ['*'], 'all_sessions');
        $allMissedSessions = TherapySession::where('attendance', 'no-show')
            ->orderBy('created_at', 'desc')->paginate(100, ['*'], 'all_missed');
        $allSpecialSessions = TherapySession::where('special', 1)
            ->orderBy('created_at', 'desc')->paginate(100, ['*'], 'all_special');

        return response()->json([
            'therapySessions' => $therapySessions,
            'therapist' => $therapist,
            'therapists' => $therapists,
            'clients' => $clients,
            'missedSessions' => $missedSessions,
            'specialSessions' => $specialSessions,
            'allTherapySessions' => $allTherapySessions,
            'allMissedSessions' => $allMissedSessions,
            'allSpecialSessions' => $allSpecialSessions,
            'user' => $user,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $user = auth()->user();
        $therapySession = TherapySession::findOrFail($id);
        $client = Client::findOrFail($therapySession->client_id);
        $therapist = User::find($therapySession->user_id);

        $attendedSessions = $client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->get();

        $defaultSpecialSessions = $client->special_sessions ?: 6;
        $specialSessionsCount = $client->therapySessions()->where('special', true)->count();
        $specialSessionsLeft = max(0, $defaultSpecialSessions - $specialSessionsCount);

        return response()->json([
            'therapySession' => $therapySession,
            'client' => $client,
            'therapist' => $therapist,
            'attendedSessions' => $attendedSessions,
            'specialSessionsLeft' => $specialSessionsLeft,
            'defaultSpecialSessions' => $defaultSpecialSessions,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        $client = Client::findOrFail($request->client_id);

        $therapist = $user->admin == 1 ? $client->user : User::find($user->id);

        $effectiveCostPerSession = $client->getEffectiveCostPerSession();

        if ($effectiveCostPerSession == null || $effectiveCostPerSession == 0) {
            return response()->json(['message' => 'No session cost set. Please set it in your profile.'], 422);
        }

        if ($client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count() >= $client->max_sessions) {
            return response()->json(['message' => 'Maximum number of sessions reached for this client.'], 422);
        }

        $specialSessionsCount = $client->therapySessions()->where('special', true)->count();

        if ($client->special_sessions && $specialSessionsCount < 6) {
            $ts = new TherapySession;
            $ts->client_id = $request->client_id;
            $ts->session_cost = 0;
            $ts->client_contribution = $client->client_contribution;
            $ts->remaining_client_contribution = $client->client_contribution;
            $ts->created_at = $request->created_at;
            $ts->user_id = $user->id;
            $ts->attendance = $request->attendance;
            $ts->notes = $request->notes;
            $ts->special = true;
            $ts->save();
        } else {
            $ts = new TherapySession;
            $ts->client_id = $request->client_id;
            $ts->session_cost = $effectiveCostPerSession;
            $ts->client_contribution = $client->client_contribution;
            $ts->remaining_client_contribution = $client->client_contribution - $effectiveCostPerSession;
            $ts->created_at = $request->created_at;
            $ts->user_id = $user->id;
            $ts->attendance = $request->attendance;
            $ts->notes = $request->notes;
            $ts->save();
        }

        // Auto-inactivate if at max sessions
        if ($client->max_sessions > 15 && $client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count() >= $client->max_sessions) {
            $client->update(['status' => 1]);
        }

        // Session limit notifications
        $currentSessionCount = $client->therapySessions()->whereIn('attendance', ['attended', 'no-show'])->count();
        if ($client->max_sessions > 15 && $currentSessionCount === ($client->max_sessions - 2) && in_array($ts->attendance, ['attended', 'no-show'])) {
            $client->notify(new SessionLimitNotification);
        }

        if ($client->special_sessions == 1 && $ts->special) {
            $currentSpecialCount = $client->therapySessions()->where('special', true)->count();
            if ($currentSpecialCount === 6) {
                $therapist->notify(new SpecialSessionsLimitNotification);
            }
        }

        // Missed session handling
        if ($ts->attendance === 'no-show') {
            $missedCount = $client->therapySessions()->where('attendance', 'no-show')->count();
            if ($missedCount >= 2) {
                $client->notify(new MissedTherapySessions($client));
                foreach (User::where('admin', 1)->get() as $admin) {
                    $admin->notify(new MissedTherapySessions($client));
                }
            }
            if ($missedCount == 1) {
                Mail::to($client->email)->send(new ClientMissedOneSession($client->preferred_name));
            } elseif ($missedCount == 2) {
                Mail::to($client->email)->send(new ClientMissedTwoSessions($client->preferred_name));
            } elseif ($missedCount == 3) {
                Mail::to($client->email)->send(new ClientMissedThreeSessions($client->preferred_name));
            }
        }

        return response()->json(['message' => 'Session added successfully.', 'session' => $ts], 201);
    }

    public function update(UpdateTherapySessionRequest $request, TherapySession $therapySession): JsonResponse
    {
        $therapySession->update([
            'session_cost' => $request->session_cost,
            'client_contribution' => $request->client_contribution,
            'remaining_client_contribution' => $request->remaining_client_contribution,
        ]);

        return response()->json(['message' => 'Session updated successfully.', 'session' => $therapySession->fresh()]);
    }

    public function destroy(TherapySession $therapySession): JsonResponse
    {
        $therapySession->delete();

        return response()->json(['message' => 'Session deleted successfully.']);
    }
}
