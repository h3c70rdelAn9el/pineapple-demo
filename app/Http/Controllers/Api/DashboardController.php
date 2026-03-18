<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChMessage as ChatMessage;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $userId = $user->id;

        if ($user->admin) {
            return $this->adminDashboard($user, $userId);
        }

        return $this->therapistDashboard($user, $userId);
    }

    private function adminDashboard(User $user, int $userId): JsonResponse
    {
        $allClients = Client::orderBy('client_code', 'asc')->paginate(30, ['*'], 'clients');
        $activeClients = Client::where('status', '0')->orderBy('client_code')->get();
        $inactiveClients = Client::where('status', '1')->orderBy('client_code')->get();

        $allTherapySessions = TherapySession::orderBy('created_at', 'desc')->paginate(10, ['*'], 'therapySessions');
        $allMissedSessions = TherapySession::where('attendance', 'no-show')->orderBy('created_at', 'desc')->paginate(15, ['*'], 'missedSessions');
        $allSpecialSessions = TherapySession::where('special', 1)->paginate(15, ['*'], 'specialSessions');

        $therapists = User::where('admin', 0)
            ->orderBy(DB::raw('COALESCE(preferred_name, name)'))
            ->paginate(15, ['*'], 'therapists');

        $inactiveTherapists = User::where('admin', 0)->where('active_status', 1)->paginate(15, ['*'], 'inactiveTherapists');
        $activeTherapists = User::where('admin', 0)->where('active_status', 0)->paginate(15, ['*'], 'activeTherapists');
        $allTherapists = User::where('admin', 0)->get(); // This returns User models

        // Ensure $allTherapists is a collection of User models (defensive, in case of future changes)
        $allTherapists = $allTherapists->map(function ($t) {
            return $t instanceof \App\Models\User ? $t : User::find($t->id);
        });

        $categories = $this->getCategories();

        $recentSessions = TherapySession::orderBy('created_at', 'desc')->take(100)->get();
        $recentActiveClients = Client::whereIn('id', $recentSessions->pluck('client_id')->unique())
            ->orderBy('created_at', 'desc')->take(10)->get();

        $unreadMessagesCount = ChatMessage::where('to_id', $user->id)->where('seen', 0)->count();

        $incompleteTherapists = $allTherapists->filter(fn($t) => !$t->isComplete()['status'] && !$t->isAdmin());
        $completeTherapistsCollection = $allTherapists->filter(fn($t) => $t->isComplete()['status'] && !$t->isAdmin());

        $incompleteTherapistsCount = $incompleteTherapists->count();
        $completeTherapistsCount = $completeTherapistsCollection->count();
        $unverifiedTherapistCount = $allTherapists->filter(fn($u) => !$u->isVerified()['status'])->count();

        $totalSessionCost = TherapySession::sum('session_cost');
        $totalClientContribution = Client::sum('client_contribution');
        $totalClientCount = Client::count();

        return response()->json([
            'user' => $user,
            'isAdmin' => true,
            'allClients' => $allClients,
            'activeClients' => $activeClients,
            'inactiveClients' => $inactiveClients,
            'therapists' => $therapists,
            'inactiveTherapists' => $inactiveTherapists,
            'activeTherapists' => $activeTherapists,
            'allTherapySessions' => $allTherapySessions,
            'allMissedSessions' => $allMissedSessions,
            'allSpecialSessions' => $allSpecialSessions,
            'recentActiveClients' => $recentActiveClients,
            'unreadMessagesCount' => $unreadMessagesCount,
            'incompleteTherapistsCount' => $incompleteTherapistsCount,
            'completeTherapistsCount' => $completeTherapistsCount,
            'unverifiedTherapistCount' => $unverifiedTherapistCount,
            'totalSessionCost' => $totalSessionCost,
            'totalClientContribution' => $totalClientContribution,
            'totalClientCount' => $totalClientCount,
            'categories' => $categories,
        ]);
    }

    private function therapistDashboard(User $user, int $userId): JsonResponse
    {
        $clients = User::find($userId)->clients()->orderBy('client_code', 'asc')->paginate(20, ['*'], 'clients');
        $therapistClients = User::find($userId)->clients()->orderBy('client_code')->paginate(20, ['*'], 'therapistClients');
        $inactiveTherapistClientsCount = User::find($userId)->clients()->where('status', '1')->count();

        $therapySessions = TherapySession::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        $attendedSessions = TherapySession::whereIn('client_id', $clients->pluck('id'))
            ->whereIn('attendance', ['attended', 'no-show'])->orderBy('created_at', 'desc')->get();

        $therapySessionsForTherapistClients = TherapySession::whereIn('client_id', $clients->pluck('id'))
            ->orderBy('created_at', 'desc')->take(10)->paginate(10);

        $client = Client::find($userId);
        $therapist = $client?->therapist;

        $unreadMessagesCount = ChatMessage::where('to_id', $user->id)->where('seen', 0)->count();

        $totalSessionCost = TherapySession::sum('session_cost');
        $totalClientContribution = Client::sum('client_contribution');

        $categories = $this->getCategories();

        $incompleteTherapist = false;
        if ($therapist) {
            $fieldsToCheck = [
                $therapist->isIdUploaded(),
                $therapist->isW9Uploaded(),
                $therapist->isLicenseUploaded(),
                $therapist->isInsuranceUploaded(),
                $therapist->isHeadshotUploaded(),
                $therapist->isBioUploaded(),
            ];
            foreach ($fieldsToCheck as $field) {
                if (is_null($field) || $field === false) {
                    $incompleteTherapist = true;
                    break;
                }
            }
        }

        return response()->json([
            'user' => $user,
            'isAdmin' => false,
            'clients' => $clients,
            'therapistClients' => $therapistClients,
            'inactiveTherapistClientsCount' => $inactiveTherapistClientsCount,
            'therapySessions' => $therapySessions,
            'attendedSessions' => $attendedSessions,
            'therapySessionsForTherapistClients' => $therapySessionsForTherapistClients,
            'incompleteTherapist' => $incompleteTherapist,
            'unreadMessagesCount' => $unreadMessagesCount,
            'totalSessionCost' => $totalSessionCost,
            'totalClientContribution' => $totalClientContribution,
            'categories' => $categories,
        ]);
    }

    private function getCategories(): array
    {
        $jsonFile = file_get_contents(resource_path('json/categories.json'));

        return json_decode($jsonFile, true);
    }
}
