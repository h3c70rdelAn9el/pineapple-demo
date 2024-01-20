<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\TherapySession;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    //
    public function index(User $user, TherapySession $therapySession)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $clients = User::find($user_id)->clients()->orderBy('client_code', 'asc')->paginate(10);
        $totalSessionCost = TherapySession::sum('session_cost');
        $totalClientContribution = Client::sum('client_contribution');
        $client = Client::find($user_id);
        $allClients = Client::orderBy('client_code', 'asc')->paginate(10, ['*'], 'clients');
        $activeClients = Client::where('status', '0')->get()->sortBy('client_code');
        $inactiveClients = Client::where('status', '1')->get()->sortBy('client_code');
        $therapySessions = TherapySession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $therapists = User::where('admin', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(10, ['*'], 'therapists');
        $therapist = Client::find($user_id)?->therapist;
        $attendedSessions = TherapySession::whereIn('client_id', $clients->pluck('id'))->whereIn('attendance', ['attended', 'no-show'])->orderBy('created_at', 'desc')->get();
        $inactiveTherapists = User::where('admin', 0)->where('active_status', 1)->get();
        $activeTherapists = User::where('admin', 0)->where('active_status', 0)->get();
        $file = file_get_contents(storage_path('states.json'));
        $states = json_decode($file, true);
        $jsonFile = file_get_contents(resource_path('json/categories.json'));
        $categories = json_decode($jsonFile, true);

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

        if ($therapist) {
            $fieldsToCheck = [
                'contract_signed' => $therapist->contract_signed,
                'public_liability_insurance' => $therapist->public_liability_insurance,
                'all_documents_received' => $therapist->all_documents_received,
            ];

            foreach ($fieldsToCheck as $field) {
                if (is_null($field) || $field === false) {
                    $incompleteTherapist = true;
                    break;
                }
            }
        } else {
            $incompleteTherapist = false;
        }

        if ($user->admin) {
            return view('dashboard_admin', [
                'user' => $user,
                'therapists' => $therapists,
                'allClients' => $allClients,
                'therapist' => $therapist,
                'therapySessions' => $therapySessions,
                'states' => $states,
                'categories' => $categories,
                'activeClients' => $activeClients,
                'inactiveClients' => $inactiveClients,
                'attendedSessions' => $attendedSessions,
                'inactiveTherapists' => $inactiveTherapists,
                'activeTherapists' => $activeTherapists,
                'incompleteTherapists' => $incompleteTherapists,
                'incompleteTherapist' => $incompleteTherapist,
                'totalSessionCost' => $totalSessionCost,
                'totalClientContribution' => $totalClientContribution,
                'client' => $client,

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
                'totalClientContribution' => $totalClientContribution]);
        }
    }
}
