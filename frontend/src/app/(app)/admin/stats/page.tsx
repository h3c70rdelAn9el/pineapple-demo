"use client";

import { useQuery } from "@tanstack/react-query";
import api from "@/lib/api";
import * as StatsActions from "@/actions/App/Http/Controllers/Api/StatsController";
import Spinner from "@/components/ui/Spinner";

export default function AdminStatsPage() {
    const { data, isLoading, isError } = useQuery<{
        totalClients: number;
        activeClients: number;
        inactiveClients: number;
        totalTherapists: number;
        activeTherapists: number;
        totalSessions: number;
        attendedSessions: number;
        noShowSessions: number;
        totalSessionCost: number;
        totalClientContribution: number;
        sessionsThisMonth: number;
        newClientsThisMonth: number;
    }>({
        queryKey: ["admin-stats"],
        queryFn: () => api.get(StatsActions.index.url()).then((r) => r.data),
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

    const statGroups = [
        {
            title: "Clients",
            color: "indigo",
            stats: [
                { label: "Total Clients", value: data.totalClients },
                { label: "Active", value: data.activeClients },
                { label: "Inactive", value: data.inactiveClients },
                { label: "New This Month", value: data.newClientsThisMonth },
            ],
        },
        {
            title: "Therapists",
            color: "green",
            stats: [
                { label: "Total", value: data.totalTherapists },
                { label: "Active", value: data.activeTherapists },
            ],
        },
        {
            title: "Sessions",
            color: "blue",
            stats: [
                { label: "Total Sessions", value: data.totalSessions },
                { label: "Attended", value: data.attendedSessions },
                { label: "No-shows", value: data.noShowSessions },
                { label: "This Month", value: data.sessionsThisMonth },
            ],
        },
        {
            title: "Financials",
            color: "yellow",
            stats: [
                {
                    label: "Total Session Cost",
                    value: `$${(data.totalSessionCost ?? 0).toLocaleString()}`,
                },
                {
                    label: "Client Contributions",
                    value: `$${(data.totalClientContribution ?? 0).toLocaleString()}`,
                },
            ],
        },
    ];

    const colorMap: Record<string, string> = {
        indigo: "text-indigo-700",
        green: "text-green-700",
        blue: "text-blue-700",
        yellow: "text-yellow-700",
    };

    return (
        <div className="space-y-8">
            <h1 className="text-2xl font-bold text-gray-900 dark:text-white">Admin Stats</h1>

            {statGroups.map((group) => (
                <section key={group.title}>
                    <h2 className="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3">
                        {group.title}
                    </h2>
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        {group.stats.map((stat) => (
                            <div
                                key={stat.label}
                                className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-4"
                            >
                                <p className="text-xs text-gray-500 dark:text-gray-400">
                                    {stat.label}
                                </p>
                                <p
                                    className={`text-2xl font-bold mt-1 ${colorMap[group.color]}`}
                                >
                                    {stat.value}
                                </p>
                            </div>
                        ))}
                    </div>
                </section>
            ))}
        </div>
    );
}
