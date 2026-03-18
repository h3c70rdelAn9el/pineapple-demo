"use client";

import { useQuery } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import { DashboardData } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import StatCard from "@/components/ui/StatCard";
import { useAuth } from "@/providers/AuthProvider";
import {
    ResponsiveContainer,
    PieChart,
    Pie,
    Cell,
    Tooltip,
    Legend,
    BarChart,
    Bar,
    XAxis,
    YAxis,
} from "recharts";

const CHART_COLORS = ["#4f46e5", "#22c55e", "#ef4444", "#f59e0b", "#8b5cf6"];

function DonutChart({ data }: { data: { name: string; value: number }[] }) {
    return (
        <ResponsiveContainer width="100%" height={200}>
            <PieChart>
                <Pie
                    data={data}
                    cx="50%"
                    cy="50%"
                    innerRadius={55}
                    outerRadius={80}
                    paddingAngle={3}
                    dataKey="value"
                >
                    {data.map((_, i) => (
                        <Cell
                            key={i}
                            fill={CHART_COLORS[i % CHART_COLORS.length]}
                        />
                    ))}
                </Pie>
                <Tooltip formatter={(v) => (v as number).toLocaleString()} />
                <Legend iconType="circle" iconSize={10} />
            </PieChart>
        </ResponsiveContainer>
    );
}

function FinancialsChart({
    sessionCost,
    clientContribution,
}: {
    sessionCost: number;
    clientContribution: number;
}) {
    const data = [
        { name: "Session Cost", value: sessionCost },
        { name: "Client Contribs", value: clientContribution },
    ];
    return (
        <ResponsiveContainer width="100%" height={200}>
            <BarChart
                data={data}
                margin={{ top: 5, right: 10, left: 30, bottom: 5 }}
            >
                <XAxis dataKey="name" tick={{ fontSize: 12 }} />
                <YAxis
                    tickFormatter={(v) => `$${(v / 1000).toFixed(0)}k`}
                    tick={{ fontSize: 11 }}
                />
                <Tooltip
                    formatter={(v) => `$${(v as number).toLocaleString()}`}
                />
                <Bar dataKey="value" radius={[4, 4, 0, 0]}>
                    <Cell fill="#22c55e" />
                    <Cell fill="#4f46e5" />
                </Bar>
            </BarChart>
        </ResponsiveContainer>
    );
}

export default function DashboardPage() {
    const { user } = useAuth();
    console.log("DashboardPage user:", user);

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
            {/* Stat cards row */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <StatCard
                    label="Total Clients"
                    value={data.totalClientCount ?? 0}
                    color="indigo"
                    href="/clients"
                />
                <StatCard
                    label="Total Therapists"
                    value={data.therapists?.total ?? 0}
                    color="green"
                    href="/therapists"
                />
                <StatCard
                    label="Unread Messages"
                    value={data.unreadMessagesCount ?? 0}
                    color="yellow"
                />
                <StatCard
                    label="No-Show Rate"
                    value={`${data.totalSessionCost ? Math.round(((data.totalClientContribution ?? 0) / data.totalSessionCost) * 100) : 0}%`}
                    sub="Contribution ratio"
                    color="red"
                    href="/sessions"
                />
            </div>

            {/* Charts grid - side by side on desktop */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div className="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                    <p className="text-sm font-medium text-gray-500 mb-3">
                        Client Distribution
                    </p>
                    <DonutChart
                        data={[
                            {
                                name: "Active",
                                value: data.activeClients?.length ?? 0,
                            },
                            {
                                name: "Inactive",
                                value: data.inactiveClients?.length ?? 0,
                            },
                        ]}
                    />
                </div>
                <div className="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                    <p className="text-sm font-medium text-gray-500 mb-3">
                        Profile Completeness
                    </p>
                    <DonutChart
                        data={[
                            {
                                name: "Complete",
                                value: data.completeTherapistsCount ?? 0,
                            },
                            {
                                name: "Incomplete",
                                value: data.incompleteTherapistsCount ?? 0,
                            },
                        ]}
                    />
                </div>
                <div className="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                    <p className="text-sm font-medium text-gray-500 mb-3">
                        Cost vs Contributions
                    </p>
                    <FinancialsChart
                        sessionCost={data.totalSessionCost ?? 0}
                        clientContribution={data.totalClientContribution ?? 0}
                    />
                </div>
            </div>

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
                                <li key={client.id}>
                                    <Link
                                        href={`/clients/${client.id}`}
                                        className="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors"
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
                                    </Link>
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
            {/* Stat cards row */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <StatCard
                    label="Your Clients"
                    value={data.clients?.total ?? 0}
                    color="indigo"
                    href="/clients"
                />
                <StatCard
                    label="Total Sessions"
                    value={totalSessions}
                    color="green"
                    href="/sessions"
                />
                <StatCard
                    label="No-Shows"
                    value={noShowSessions}
                    color="red"
                    href="/sessions"
                />
                <StatCard
                    label="Unread Messages"
                    value={data.unreadMessagesCount ?? 0}
                    color="yellow"
                />
            </div>

            {/* Chart + client list side by side on desktop */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {totalSessions > 0 && (
                    <div className="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                        <p className="text-sm font-medium text-gray-500 mb-3">
                            Session Attendance
                        </p>
                        <DonutChart
                            data={[
                                {
                                    name: "Attended",
                                    value:
                                        data.therapySessions?.filter(
                                            (s) => s.attendance === "attended",
                                        ).length ?? 0,
                                },
                                {
                                    name: "No-Show",
                                    value:
                                        data.therapySessions?.filter(
                                            (s) => s.attendance === "no-show",
                                        ).length ?? 0,
                                },
                                {
                                    name: "Missed",
                                    value:
                                        data.therapySessions?.filter(
                                            (s) => s.attendance === "missed",
                                        ).length ?? 0,
                                },
                            ].filter((d) => d.value > 0)}
                        />
                    </div>
                )}

                <div>
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
                                    <li key={client.id}>
                                        <Link
                                            href={`/clients/${client.id}`}
                                            className="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors"
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
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}
