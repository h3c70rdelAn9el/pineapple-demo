<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - System Statistics</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('System Statistics') }}
                </h2>
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Back to Dashboard
                </a>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Filter Section -->
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form method="GET" action="{{ route('admin.stats') }}" id="stats-filter-form" class="flex flex-wrap items-end gap-4">
                            <!-- Year Filter -->
                            <div class="flex-1 min-w-[200px]">
                                <label for="year" class="block mb-2 text-sm font-medium text-gray-700">
                                    Year
                                </label>
                                <select name="year" id="year" 
                                        onchange="document.getElementById('stats-filter-form').submit()"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($availableYears as $availableYear)
                                        <option value="{{ $availableYear }}" {{ $year == $availableYear ? 'selected' : '' }}>
                                            {{ $availableYear }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Month Filter -->
                            <div class="flex-1 min-w-[200px]">
                                <label for="month" class="block mb-2 text-sm font-medium text-gray-700">
                                    Month (Optional)
                                </label>
                                <select name="month" id="month" 
                                        onchange="document.getElementById('stats-filter-form').submit()"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Months</option>
                                    <option value="1" {{ $month == 1 ? 'selected' : '' }}>January</option>
                                    <option value="2" {{ $month == 2 ? 'selected' : '' }}>February</option>
                                    <option value="3" {{ $month == 3 ? 'selected' : '' }}>March</option>
                                    <option value="4" {{ $month == 4 ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ $month == 5 ? 'selected' : '' }}>May</option>
                                    <option value="6" {{ $month == 6 ? 'selected' : '' }}>June</option>
                                    <option value="7" {{ $month == 7 ? 'selected' : '' }}>July</option>
                                    <option value="8" {{ $month == 8 ? 'selected' : '' }}>August</option>
                                    <option value="9" {{ $month == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $month == 10 ? 'selected' : '' }}>October</option>
                                    <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $month == 12 ? 'selected' : '' }}>December</option>
                                </select>
                            </div>

                            <!-- Submit Button (optional - form auto-submits on change) -->
                            <div>
                                <button type="submit" 
                                        class="px-6 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Clients -->
                    <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Total Clients</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_clients'] }}</div>
                        </div>
                    </div>

                    <!-- Active Clients -->
                    <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Active Clients</div>
                            <div class="mt-2 text-3xl font-bold text-green-600">{{ $stats['active_clients'] }}</div>
                        </div>
                    </div>

                    <!-- Total Sessions -->
                    <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Total Sessions</div>
                            <div class="mt-2 text-3xl font-bold text-blue-600">{{ $stats['total_sessions'] }}</div>
                        </div>
                    </div>

                    <!-- Attendance Rate -->
                    <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-500">Attendance Rate</div>
                            <div class="mt-2 text-3xl font-bold text-purple-600">{{ $stats['attendance_rate'] }}%</div>
                        </div>
                    </div>
                </div>

                <!-- Client Statistics -->
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Client Statistics</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Inactive Clients</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['inactive_clients'] }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Waitlist Clients</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['waitlist_clients'] }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Special Sessions Clients</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['special_sessions_clients'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Session Statistics -->
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Session Statistics</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Attended Sessions</div>
                                <div class="mt-1 text-2xl font-bold text-green-600">{{ $stats['attended_sessions'] }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Missed Sessions</div>
                                <div class="mt-1 text-2xl font-bold text-red-600">{{ $stats['missed_sessions'] }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Avg Sessions/Client</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['avg_sessions_per_client'] }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Avg Sessions/Active Client</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['avg_sessions_per_active_client'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Statistics -->
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Financial Statistics</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Total PS Cost</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">${{ number_format($stats['total_ps_cost'], 2) }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Total Client Contributions</div>
                                <div class="mt-1 text-2xl font-bold text-green-600">${{ number_format($stats['total_client_contributions'], 2) }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Net PS Cost</div>
                                <div class="mt-1 text-2xl font-bold text-blue-600">${{ number_format($stats['net_ps_cost'], 2) }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Avg Cost/Session</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">${{ number_format($stats['avg_cost_per_session'], 2) }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Avg PS Cost/Client</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">${{ number_format($stats['avg_cost_per_client'], 2) }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Avg Net Cost/Client</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">${{ number_format($stats['avg_net_cost_per_client'], 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Therapist Statistics -->
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Therapist Statistics</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Active Therapists</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['active_therapists'] }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Total Therapists</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['total_therapists'] }}</div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50">
                                <div class="text-sm text-gray-600">Avg Clients/Therapist</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['avg_clients_per_therapist'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clients by Category -->
                @if(!empty($stats['clients_by_category']))
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Clients by Category</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Category</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Client Count</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($stats['clients_by_category'] as $category => $count)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $category }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Top Therapists by Sessions -->
                @if($stats['sessions_by_therapist']->isNotEmpty())
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Top Therapists by Sessions</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Therapist</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Session Count</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($stats['sessions_by_therapist'] as $therapist)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $therapist['therapist_name'] }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $therapist['session_count'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Monthly Trend (only shown when viewing full year) -->
                @if(!$month && !empty($stats['new_clients_trend']))
                <div class="mb-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">New Clients Trend - {{ $year }}</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Month</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">New Clients</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    @endphp
                                    @foreach($months as $index => $monthName)
                                        @php $monthNum = $index + 1; @endphp
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $monthName }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                {{ $stats['new_clients_trend'][$monthNum] ?? 0 }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </x-app-layout>
</body>
</html>
