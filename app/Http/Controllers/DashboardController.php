<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Message;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ChMessage as ChatMessage;


class DashboardController extends Controller
{
    //
    public function index(User $user, TherapySession $therapySession)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $clients = User::find($user_id)->clients()->orderBy('client_code', 'asc')->paginate(15, ['*'], 'clients');
        $totalClientCount = Client::count();
        $totalSessionCost = TherapySession::sum('session_cost');
        $totalClientContribution = Client::sum('client_contribution');
        $client = Client::find($user_id);
        $allClients = Client::orderBy('client_code', 'asc')->paginate(10, ['*'], 'clients');
        $activeClients = Client::where('status', '0')->get()->sortBy('client_code');
        $inactiveClients = Client::where('status', '1')->get()->sortBy('client_code');
        $therapistClients = User::find($user_id)->clients()->orderBy('client_code')->paginate(10, ['*'], 'therapistClients');
        $inactiveTherapistClientsCount = User::find($user_id)->clients()->where('status', '1')->count();
        $recentClientWithSessions = TherapySession::orderBy('created_at', 'desc')->take(10)->with('client')->get()->pluck('client')->unique('id');
        $latestActiveClient = Client::where('status', '0')->orderBy('created_at', 'desc')->first();
        $therapySessions = TherapySession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $therapySession = TherapySession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $allTherapySessions = TherapySession::orderBy('created_at', 'desc')->paginate('10', ['*'], 'therapySessions');
        $attendedSessions = TherapySession::whereIn('client_id', $clients->pluck('id'))->whereIn('attendance', ['attended', 'no-show'])->orderBy('created_at', 'desc')->get();
        $missedSessions = TherapySession::where('user_id', $user->id)
            ->where('attendance', 'missed')
            ->orderBy('created_at', 'desc')
            ->get();

        $allMissedSessions = TherapySession::where('attendance', 'no-show')
            ->orderBy('created_at', 'desc')
            ->paginate('15', ['*'], 'missedSessions');

        $allSpecialSessions = TherapySession::where('special',  1)->paginate('15', ['*'], 'specialSessions');

        $recentSessions = TherapySession::orderBy('created_at', 'desc')->take(100)->get();
        $recentActiveClients = Client::whereIn('id', $recentSessions->pluck('client_id')->unique())->orderBy('created_at', 'desc')->take(10)->get();

        $therapists = User::where('admin', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(15, ['*'], 'therapists');
        $therapist = Client::find($user_id)?->therapist;
        $inactiveTherapists = User::where('admin', 0)->where('active_status', 1)->get();
        $activeTherapists = User::where('admin', 0)->where('active_status', 0)->get();

        $file = file_get_contents(storage_path('states.json'));
        $states = json_decode($file, true);
        $jsonFile = file_get_contents(resource_path('json/categories.json'));
        $categories = json_decode($jsonFile, true);
        $therapySessionsForTherapistClients = TherapySession::whereIn('client_id', $clients->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->paginate(10);

        $unreadMessagesCount = ChatMessage::where('to_id', $user->id)
        ->where('seen', 0)
        ->count();

        if ($therapists) {
            $incompleteTherapists = $therapists->filter(function ($therapist) {
                $fieldsToCheck = [
                    'contract_signed' => $therapist->contract_signed,
                    'public_liability_insurance' => $therapist->public_liability_insurance,
                    'all_documents' => $therapist->all_documents,
                    'signed_documents' => $therapist->signed_documents,
                    'leah_signed' => $therapist->leah_signed,
                ];

                foreach ($fieldsToCheck as $field) {
                    if (is_null($field) || $field === false) {
                        return true;
                    }
                }

                return false;
            });
        } else {
            $incompleteTherapists = collect();
        }

        $incompleteTherapist = false;

        if ($user) {
            $fieldsToCheck = [
                'id_uploaded' => $user->id_uploaded,
                'W9_or_WBEN_uploaded' => $user->W9_or_WBEN_uploaded,
                'license_uploaded' => $user->license_uploaded,
                'insurance_uploaded' => $user->insurance_uploaded,
                'headshot_uploaded' => $user->headshot_uploaded,
            ];

            foreach ($fieldsToCheck as $field) {
                if (is_null($field) || $field === false) {
                    $incompleteTherapist = true;
                    break;
                }
            }
        }

        $incompleteTherapistsCount = User::where('admin', 0)
        ->where(function ($query) {
            $query->where('id_uploaded', false)
            ->orWhere('W9_or_WBEN_uploaded', false)
            ->orWhere('license_uploaded', false)
            ->orWhere('insurance_uploaded', false)
            ->orWhere('headshot_uploaded', false);
        })
            ->count();


        if ($user->admin) {
            return view('dashboard_admin', [
                'user' => $user,
                'therapists' => $therapists,
                'allClients' => $allClients,
                'therapist' => $therapist,
                'states' => $states,
                'categories' => $categories,
                'activeClients' => $activeClients,
                'inactiveClients' => $inactiveClients,
                'therapySessions' => $therapySessions,
                'attendedSessions' => $attendedSessions,
                'missedSessions' => $missedSessions,
                'inactiveTherapists' => $inactiveTherapists,
                'activeTherapists' => $activeTherapists,
                // 'incompleteTherapists' => $incompleteTherapists,
                'incompleteTherapist' => $incompleteTherapist,
                'totalSessionCost' => $totalSessionCost,
                'totalClientContribution' => $totalClientContribution,
                'client' => $client,
                'clients' => $clients,
                'totalClientCount' => $totalClientCount,
                'allTherapySessions' => $allTherapySessions,
                'therapySession' => $therapySession,
                'allMissedSessions' => $allMissedSessions,
                'allSpecialSessions' => $allSpecialSessions,
                'recentActiveClients' => $recentActiveClients,
                'unreadMessagesCount' => $unreadMessagesCount,
                'incompleteTherapistsCount' => $incompleteTherapistsCount
            ]);
        } else {
            return view('dashboard', [
                'user' => $user,
                'clients' => $clients,
                'client' => $client,
                'therapySessions' => $therapySessions,
                'therapist' => $therapist,
                'states' => $states,
                'categories' => $categories,
                'activeClients' => $activeClients,
                'inactiveClients' => $inactiveClients,
                'attendedSessions' => $attendedSessions,
                'incompleteTherapist' => $incompleteTherapist,
                'totalSessionCost' => $totalSessionCost,
                'totalClientContribution' => $totalClientContribution,
                'therapySessionsForTherapistClients' => $therapySessionsForTherapistClients,
                'inactiveTherapistClientsCount' => $inactiveTherapistClientsCount,
                'therapistClients' => $therapistClients,
                'unreadMessagesCount' => $unreadMessagesCount,
            ]);
        }
    }
}
