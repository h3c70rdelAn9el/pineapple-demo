<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        if (!$request->user()?->admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $year = $request->input('year', now()->year);
        $month = $request->input('month', null);

        $availableYears = collect([
            Client::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year'),
            TherapySession::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year'),
        ])->flatten()->unique()->sort()->values();

        if ($availableYears->isEmpty()) {
            $availableYears = collect([now()->year]);
        }

        $stats = $this->calculateStats($year, $month);

        return response()->json([
            'stats' => $stats,
            'year' => $year,
            'month' => $month,
            'availableYears' => $availableYears,
        ]);
    }

    private function calculateStats(int $year, ?int $month = null): array
    {
        $clientQuery = Client::query();
        $sessionQuery = TherapySession::query();

        if ($year) {
            $clientQuery->whereYear('created_at', $year);
            $sessionQuery->whereYear('created_at', $year);
        }

        if ($month) {
            $clientQuery->whereMonth('created_at', $month);
            $sessionQuery->whereMonth('created_at', $month);
        }

        $totalClients = (clone $clientQuery)->count();
        $activeClients = (clone $clientQuery)->where('status', '!=', 1)->count();
        $inactiveClients = (clone $clientQuery)->where('status', 1)->count();
        $waitlistClients = (clone $clientQuery)->where('waitlist', 1)->count();

        $totalSessions = (clone $sessionQuery)->count();
        $attendedSessions = (clone $sessionQuery)->where('attendance', 'attended')->count();
        $missedSessions = (clone $sessionQuery)->where('attendance', 'no-show')->count();

        $avgSessionsPerClient = $totalClients > 0 ? round($totalSessions / $totalClients, 2) : 0;

        $totalSessionCost = (clone $sessionQuery)->sum('session_cost');
        $totalClientContribution = (clone $clientQuery)->sum('client_contribution');

        $totalTherapists = User::where('admin', 0)->count();
        $activeTherapists = User::where('admin', 0)->where('active_status', 1)->count();

        // Monthly breakdown
        $monthlyData = TherapySession::query()
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as sessions, SUM(session_cost) as cost')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return [
            'totalClients' => $totalClients,
            'activeClients' => $activeClients,
            'inactiveClients' => $inactiveClients,
            'waitlistClients' => $waitlistClients,
            'totalSessions' => $totalSessions,
            'attendedSessions' => $attendedSessions,
            'missedSessions' => $missedSessions,
            'avgSessionsPerClient' => $avgSessionsPerClient,
            'totalSessionCost' => $totalSessionCost,
            'totalClientContribution' => $totalClientContribution,
            'totalTherapists' => $totalTherapists,
            'activeTherapists' => $activeTherapists,
            'monthlyData' => $monthlyData,
        ];
    }
}
