"use client";

import { useQuery } from "@tanstack/react-query";
import api from "@/lib/api";
import { DashboardData } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import { useAuth } from "@/providers/AuthProvider";

function StatCard({
    label,
    value,
    sub,
    color = "indigo",
}: {
    label: string;
    value: string | number;
    sub?: string;
    color?: string;
}) {
    const colors: Record<string, string> = {
        indigo: "bg-indigo-50 text-indigo-700",
        green: "bg-green-50 text-green-700",
        red: "bg-red-50 text-red-700",
        yellow: "bg-yellow-50 text-yellow-700",
    };
    return (
        <div className="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
            <p className="text-sm font-medium text-gray-500">{label}</p>
            <p
                className={`mt-1 text-3xl font-bold ${colors[color] ?? colors.indigo}`}
            >
                {value}
            </p>
            {sub && <p className="mt-1 text-xs text-gray-400">{sub}</p>}
        </div>
    );
}

export default function DashboardPage() {
    const { user } = useAuth();

    const { data, isLoading, isError } = useQuery<DashboardData>({
        queryKey: ["dashboard"],
        queryFn: () => api.get("/api/dashboard").then((r) => r.data),
    });

    if (isLoading) {
        return (
            <div className="flex items-center justify-center py-24">
                <Spinner className="h-8 w-8" />
            </div>
        );
    }

    if (isError || !data) {
        return (
            <div className="rounded-md bg-red-50 p-4 text-red-700 text-sm">
                Failed to load dashboard data.
            </div>
        );
    }

    const isAdmin = data.isAdmin;

    return (
        <div className="space-y-8">
            <div>
                <h1 className="text-2xl font-bold text-gray-900">
                    Welcome back, {user?.preferred_name ?? user?.name} 👋
                </h1>
                <p className="text-sm text-gray-500 mt-1">
                    {isAdmin ? "Admin overview" : "Your practice overview"}
                </p>
            </div>

            {isAdmin ? (
                <AdminDashboard data={data} />
            ) : (
                <TherapistDashboard data={data} />
            )}
        </div>
    );
}

function AdminDashboard({ data }: { data: DashboardData }) {
    return (
        <div className="space-y-8">
            <section>
                <h2 className="text-lg font-semibold text-gray-700 mb-4">
                    Overview
                </h2>
                <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    <StatCard
                        label="Total Clients"
                        value={data.totalClientCount ?? 0}
                        color="indigo"
                    />
                    <StatCard
                        label="Active Clients"
                        value={data.activeClients?.length ?? 0}
                        color="green"
                    />
                    <StatCard
                        label="Inactive Clients"
                        value={data.inactiveClients?.length ?? 0}
                        color="red"
                    />
                    <StatCard
                        label="Unread Messages"
                        value={data.unreadMessagesCount ?? 0}
                        color="yellow"
                    />
                </div>
            </section>

            <section>
                <h2 className="text-lg font-semibold text-gray-700 mb-4">
                    Therapists
                </h2>
                <div className="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <StatCard
                        label="Total Therapists"
                        value={data.therapists?.total ?? 0}
                        color="indigo"
                    />
                    <StatCard
                        label="Complete Profiles"
                        value={data.completeTherapistsCount ?? 0}
                        color="green"
                    />
                    <StatCard
                        label="Incomplete Profiles"
                        value={data.incompleteTherapistsCount ?? 0}
                        color="red"
                    />
                </div>
            </section>

            <section>
                <h2 className="text-lg font-semibold text-gray-700 mb-4">
                    Financials
                </h2>
                <div className="grid grid-cols-2 sm:grid-cols-2 gap-4">
                    <StatCard
                        label="Total Session Cost"
                        value={`$${(data.totalSessionCost ?? 0).toLocaleString()}`}
                        color="green"
                    />
                    <StatCard
                        label="Total Client Contributions"
                        value={`$${(data.totalClientContribution ?? 0).toLocaleString()}`}
                        color="indigo"
                    />
                </div>
            </section>

            <section>
                <h2 className="text-lg font-semibold text-gray-700 mb-4">
                    Recent Active Clients
                </h2>
                <div className="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                    {(data.recentActiveClients?.length ?? 0) === 0 ? (
                        <p className="p-4 text-sm text-gray-500">
                            No recent clients.
                        </p>
                    ) : (
                        <ul className="divide-y divide-gray-100">
                            {data.recentActiveClients?.map((client) => (
                                <li
                                    key={client.id}
                                    className="px-4 py-3 flex items-center justify-between"
                                >
                                    <div>
                                        <p className="text-sm font-medium text-gray-900">
                                            {client.preferred_name ??
                                                client.legal_name}
                                        </p>
                                        <p className="text-xs text-gray-500">
                                            {client.client_code}
                                        </p>
                                    </div>
                                    <Badge
                                        variant={
                                            client.status === 0
                                                ? "green"
                                                : "red"
                                        }
                                    >
                                        {client.status === 0
                                            ? "Active"
                                            : "Inactive"}
                                    </Badge>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </section>
        </div>
    );
}

function TherapistDashboard({ data }: { data: DashboardData }) {
    const totalSessions = data.therapySessions?.length ?? 0;
    const noShowSessions =
        data.therapySessions?.filter((s) => s.attendance === "no-show")
            .length ?? 0;

    return (
        <div className="space-y-8">
            <section>
                <h2 className="text-lg font-semibold text-gray-700 mb-4">
                    Your Overview
                </h2>
                <div className="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <StatCard
                        label="Your Clients"
                        value={data.clients?.total ?? 0}
                        color="indigo"
                    />
                    <StatCard
                        label="Total Sessions"
                        value={totalSessions}
                        color="green"
                    />
                    <StatCard
                        label="No-Show Sessions"
                        value={noShowSessions}
                        color="red"
                    />
                </div>
            </section>

            <section>
                <h2 className="text-lg font-semibold text-gray-700 mb-4">
                    Your Clients
                </h2>
                <div className="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                    {(data.clients?.data?.length ?? 0) === 0 ? (
                        <p className="p-4 text-sm text-gray-500">
                            No clients assigned yet.
                        </p>
                    ) : (
                        <ul className="divide-y divide-gray-100">
                            {data.clients?.data?.map((client) => (
                                <li
                                    key={client.id}
                                    className="px-4 py-3 flex items-center justify-between"
                                >
                                    <div>
                                        <p className="text-sm font-medium text-gray-900">
                                            {client.preferred_name ??
                                                client.legal_name}
                                        </p>
                                        <p className="text-xs text-gray-500">
                                            {client.client_code}
                                        </p>
                                    </div>
                                    <Badge
                                        variant={
                                            client.status === 0
                                                ? "green"
                                                : "red"
                                        }
                                    >
                                        {client.status === 0
                                            ? "Active"
                                            : "Inactive"}
                                    </Badge>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </section>
        </div>
    );
}
