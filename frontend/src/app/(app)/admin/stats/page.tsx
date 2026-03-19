"use client";

import { useState } from "react";
import { useQuery } from "@tanstack/react-query";
import api from "@/lib/api";
import * as StatsActions from "@/actions/App/Http/Controllers/Api/StatsController";
import Spinner from "@/components/ui/Spinner";
import {
    BarChart,
    Bar,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    ResponsiveContainer,
    PieChart,
    Pie,
    Cell,
    Legend,
} from "recharts";

type MonthlyDataItem = {
    month: number;
    sessions: number;
    cost: number;
};

type StatsData = {
    stats: {
        totalClients: number;
        activeClients: number;
        inactiveClients: number;
        waitlistClients: number;
        totalTherapists: number;
        activeTherapists: number;
        totalSessions: number;
        attendedSessions: number;
        missedSessions: number;
        avgSessionsPerClient: number;
        totalSessionCost: number;
        totalClientContribution: number;
        monthlyData: MonthlyDataItem[];
    };
    year: number;
    availableYears: number[];
};

const MONTH_NAMES = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
];

const PIE_COLORS = ["#6366f1", "#ef4444", "#94a3b8"];

export default function AdminStatsPage() {
    const [year, setYear] = useState(new Date().getFullYear());

    const { data, isLoading, isError } = useQuery<StatsData>({
        queryKey: ["admin-stats", year],
        queryFn: () =>
            api
                .get(StatsActions.index.url(), { params: { year } })
                .then((r) => r.data),
    });

    if (isLoading) {
        return (
            <div className="flex justify-center py-24">
                <Spinner className="h-8 w-8" />
            </div>
        );
    }

    if (isError || !data) {
        return (
            <div className="rounded-md bg-red-50 p-4 text-red-700 text-sm">
                Failed to load stats.
            </div>
        );
    }

    const s = data.stats;

    const monthlyChartData = s.monthlyData.map((d) => ({
        name: MONTH_NAMES[d.month - 1],
        Sessions: d.sessions,
    }));

    const attendanceData = [
        { name: "Attended", value: s.attendedSessions },
        { name: "No-show", value: s.missedSessions },
        {
            name: "Other",
            value: Math.max(
                0,
                s.totalSessions - s.attendedSessions - s.missedSessions,
            ),
        },
    ].filter((d) => d.value > 0);

    const statGroups = [
        {
            title: "Clients",
            color: "indigo",
            bg: "bg-indigo-50 dark:bg-indigo-950/30 border-indigo-100 dark:border-indigo-900",
            text: "text-indigo-600 dark:text-indigo-400",
            stats: [
                { label: "Total", value: s.totalClients },
                { label: "Active", value: s.activeClients },
                { label: "Inactive", value: s.inactiveClients },
                { label: "Waitlist", value: s.waitlistClients },
            ],
        },
        {
            title: "Therapists",
            color: "green",
            bg: "bg-emerald-50 dark:bg-emerald-950/30 border-emerald-100 dark:border-emerald-900",
            text: "text-emerald-600 dark:text-emerald-400",
            stats: [
                { label: "Total", value: s.totalTherapists },
                { label: "Active", value: s.activeTherapists },
            ],
        },
        {
            title: "Sessions",
            color: "blue",
            bg: "bg-blue-50 dark:bg-blue-950/30 border-blue-100 dark:border-blue-900",
            text: "text-blue-600 dark:text-blue-400",
            stats: [
                { label: "Total", value: s.totalSessions },
                { label: "Attended", value: s.attendedSessions },
                { label: "No-shows", value: s.missedSessions },
                { label: "Avg / Client", value: s.avgSessionsPerClient },
            ],
        },
        {
            title: "Financials",
            color: "yellow",
            bg: "bg-amber-50 dark:bg-amber-950/30 border-amber-100 dark:border-amber-900",
            text: "text-amber-600 dark:text-amber-400",
            stats: [
                {
                    label: "Total Session Cost",
                    value: `$${(s.totalSessionCost ?? 0).toLocaleString()}`,
                },
                {
                    label: "Client Contributions",
                    value: `$${(s.totalClientContribution ?? 0).toLocaleString()}`,
                },
            ],
        },
    ];

    return (
        <div className="space-y-8">
            {/* Header */}
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                    Admin Stats
                </h1>
                <select
                    value={year}
                    onChange={(e) => setYear(Number(e.target.value))}
                    className="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 px-3 py-1.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    {data.availableYears.map((y) => (
                        <option key={y} value={y}>
                            {y}
                        </option>
                    ))}
                </select>
            </div>

            {/* Stat Card Groups */}
            {statGroups.map((group) => (
                <section key={group.title}>
                    <h2 className="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">
                        {group.title}
                    </h2>
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        {group.stats.map((stat) => (
                            <div
                                key={stat.label}
                                className={`rounded-xl border shadow-sm p-5 ${group.bg}`}
                            >
                                <p className="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {stat.label}
                                </p>
                                <p
                                    className={`text-3xl font-bold mt-1 ${group.text}`}
                                >
                                    {stat.value}
                                </p>
                            </div>
                        ))}
                    </div>
                </section>
            ))}

            {/* Charts */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {/* Monthly Sessions Bar Chart */}
                <div className="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <h3 className="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-5">
                        Monthly Sessions — {year}
                    </h3>
                    {monthlyChartData.length > 0 ? (
                        <ResponsiveContainer width="100%" height={220}>
                            <BarChart data={monthlyChartData} barSize={28}>
                                <CartesianGrid
                                    strokeDasharray="3 3"
                                    stroke="#e5e7eb"
                                    vertical={false}
                                />
                                <XAxis
                                    dataKey="name"
                                    tick={{ fontSize: 11, fill: "#9ca3af" }}
                                    axisLine={false}
                                    tickLine={false}
                                />
                                <YAxis
                                    tick={{ fontSize: 11, fill: "#9ca3af" }}
                                    axisLine={false}
                                    tickLine={false}
                                    allowDecimals={false}
                                />
                                <Tooltip
                                    cursor={{ fill: "#f3f4f6" }}
                                    contentStyle={{
                                        borderRadius: "8px",
                                        border: "1px solid #e5e7eb",
                                        fontSize: "12px",
                                    }}
                                />
                                <Bar
                                    dataKey="Sessions"
                                    fill="#6366f1"
                                    radius={[5, 5, 0, 0]}
                                />
                            </BarChart>
                        </ResponsiveContainer>
                    ) : (
                        <p className="text-sm text-gray-400 text-center py-12">
                            No session data for {year}.
                        </p>
                    )}
                </div>

                {/* Session Attendance Donut Chart */}
                <div className="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <h3 className="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-5">
                        Session Attendance Breakdown
                    </h3>
                    {attendanceData.length > 0 ? (
                        <ResponsiveContainer width="100%" height={220}>
                            <PieChart>
                                <Pie
                                    data={attendanceData}
                                    cx="50%"
                                    cy="50%"
                                    innerRadius={60}
                                    outerRadius={90}
                                    paddingAngle={3}
                                    dataKey="value"
                                >
                                    {attendanceData.map((_, index) => (
                                        <Cell
                                            key={`cell-${index}`}
                                            fill={
                                                PIE_COLORS[
                                                    index % PIE_COLORS.length
                                                ]
                                            }
                                        />
                                    ))}
                                </Pie>
                                <Legend
                                    wrapperStyle={{
                                        fontSize: "12px",
                                        color: "#6b7280",
                                    }}
                                />
                                <Tooltip
                                    contentStyle={{
                                        borderRadius: "8px",
                                        border: "1px solid #e5e7eb",
                                        fontSize: "12px",
                                    }}
                                />
                            </PieChart>
                        </ResponsiveContainer>
                    ) : (
                        <p className="text-sm text-gray-400 text-center py-12">
                            No session data available.
                        </p>
                    )}
                </div>
            </div>
        </div>
    );
}
