<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Display system statistics with year/month filtering
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check admin access
        if (! auth()->user() || auth()->user()->admin != 1) {
            return redirect()->route('dashboard')->with('error', '**You do not have permission to access that page**');
        }

        // Get filter parameters
        $year = $request->input('year', now()->year);
        $month = $request->input('month', null);

        // Get available years from clients and sessions
        $availableYears = collect([
            Client::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year'),
            TherapySession::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year'),
        ])->flatten()->unique()->sort()->values();

        if ($availableYears->isEmpty()) {
            $availableYears = collect([now()->year]);
        }

        // Calculate statistics
        $stats = $this->calculateStats($year, $month);

        return view('admin.stats', [
            'stats' => $stats,
            'year' => $year,
            'month' => $month,
            'availableYears' => $availableYears,
        ]);
    }

    /**
     * Calculate all statistics based on filters
     */
    private function calculateStats($year, $month = null)
    {
        // Base query constraints
        $clientQuery = Client::query();
        $sessionQuery = TherapySession::query();

        // Apply year filter
        if ($year) {
            $clientQuery->whereYear('created_at', $year);
            $sessionQuery->whereYear('created_at', $year);
        }

        // Apply month filter if specified
        if ($month) {
            $clientQuery->whereMonth('created_at', $month);
            $sessionQuery->whereMonth('created_at', $month);
        }

        // Clone queries for different calculations
        $clientStats = clone $clientQuery;
        $sessionStats = clone $sessionQuery;

        // 1. Total clients in period
        $totalClients = $clientStats->count();

        // 2. Active vs Inactive clients
        $activeClients = (clone $clientQuery)->where('status', '!=', 1)->count();
        $inactiveClients = (clone $clientQuery)->where('status', 1)->count();
        $waitlistClients = (clone $clientQuery)->where('waitlist', 1)->count();

        // 3. Total therapy sessions
        $totalSessions = $sessionStats->count();
        $attendedSessions = (clone $sessionQuery)->where('attendance', 'attended')->count();
        $missedSessions = (clone $sessionQuery)->where('attendance', 'no-show')->count();

        // 4. Average sessions per client (for clients with at least one session)
        $avgSessionsPerClient = $totalClients > 0
            ? round($totalSessions / $totalClients, 2)
            : 0;

        // 5. Average sessions per active client
        $avgSessionsPerActiveClient = $activeClients > 0
            ? round((clone $sessionQuery)->whereHas('client', function ($q) use ($year, $month) {
                $q->where('status', '!=', 1);
                if ($year) {
                    $q->whereYear('clients.created_at', $year);
                }
                if ($month) {
                    $q->whereMonth('clients.created_at', $month);
                }
            })->count() / $activeClients, 2)
            : 0;

        // 6. Average cost per session (PS cost)
        $avgCostPerSession = (clone $sessionQuery)
            ->whereNotNull('session_cost')
            ->avg('session_cost') ?? 0;
        $avgCostPerSession = round($avgCostPerSession, 2);

        // 7. Total PS cost
        $totalPSCost = (clone $sessionQuery)
            ->whereNotNull('session_cost')
            ->sum('session_cost') ?? 0;
        $totalPSCost = round($totalPSCost, 2);

        // 8. Average PS cost per client
        $avgCostPerClient = $totalClients > 0
            ? round($totalPSCost / $totalClients, 2)
            : 0;

        // 9. Client contributions
        $totalClientContributions = (clone $sessionQuery)
            ->whereNotNull('client_contribution')
            ->sum('client_contribution') ?? 0;
        $totalClientContributions = round($totalClientContributions, 2);

        // 10. Net PS cost (total PS cost - client contributions)
        $netPSCost = round($totalPSCost - $totalClientContributions, 2);

        // 11. Average net PS cost per client
        $avgNetCostPerClient = $totalClients > 0
            ? round($netPSCost / $totalClients, 2)
            : 0;

        // 12. Therapist statistics
        $activeTherapists = User::where('admin', 0)->where('active_status', 1)->count();
        $totalTherapists = User::where('admin', 0)->count();

        // 13. Average clients per therapist
        $avgClientsPerTherapist = $activeTherapists > 0
            ? round($activeClients / $activeTherapists, 2)
            : 0;

        // 14. Clients by category
        $clientsByCategory = (clone $clientQuery)
            ->select('category', DB::raw('count(*) as count'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        // 15. Sessions by therapist (top 10)
        $sessionsByTherapist = (clone $sessionQuery)
            ->select('user_id', DB::raw('count(*) as session_count'))
            ->whereNotNull('user_id')
            ->where('user_id', '!=', 200) // Exclude "no therapist" placeholder
            ->groupBy('user_id')
            ->orderByDesc('session_count')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $therapist = User::find($item->user_id);

                return [
                    'therapist_name' => $therapist ? ($therapist->preferred_name ?? $therapist->name) : 'Unknown',
                    'session_count' => $item->session_count,
                ];
            });

        // 16. Attendance rate
        $attendanceRate = $totalSessions > 0
            ? round(($attendedSessions / $totalSessions) * 100, 1)
            : 0;

        // 17. Special sessions clients
        $specialSessionsClients = (clone $clientQuery)->where('special_sessions', '>', 0)->count();

        // 18. New clients trend (monthly breakdown if viewing a year)
        $newClientsTrend = [];
        if ($year && ! $month) {
            $newClientsTrend = Client::whereYear('created_at', $year)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
        }

        return [
            'total_clients' => $totalClients,
            'active_clients' => $activeClients,
            'inactive_clients' => $inactiveClients,
            'waitlist_clients' => $waitlistClients,
            'total_sessions' => $totalSessions,
            'attended_sessions' => $attendedSessions,
            'missed_sessions' => $missedSessions,
            'avg_sessions_per_client' => $avgSessionsPerClient,
            'avg_sessions_per_active_client' => $avgSessionsPerActiveClient,
            'avg_cost_per_session' => $avgCostPerSession,
            'total_ps_cost' => $totalPSCost,
            'avg_cost_per_client' => $avgCostPerClient,
            'total_client_contributions' => $totalClientContributions,
            'net_ps_cost' => $netPSCost,
            'avg_net_cost_per_client' => $avgNetCostPerClient,
            'active_therapists' => $activeTherapists,
            'total_therapists' => $totalTherapists,
            'avg_clients_per_therapist' => $avgClientsPerTherapist,
            'clients_by_category' => $clientsByCategory,
            'sessions_by_therapist' => $sessionsByTherapist,
            'attendance_rate' => $attendanceRate,
            'special_sessions_clients' => $specialSessionsClients,
            'new_clients_trend' => $newClientsTrend,
        ];
    }
}
