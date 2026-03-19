"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import * as ClientActions from "@/actions/App/Http/Controllers/Api/ClientController";
import { ClientsData, Client } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";
import Modal from "@/components/ui/Modal";
import DataTable from "@/components/ui/DataTable";
import PageTabs from "@/components/ui/PageTabs";
import DonutChart from "@/components/ui/DonutChart";
import {
    ResponsiveContainer,
    BarChart,
    Bar,
    XAxis,
    YAxis,
    Tooltip,
    Cell,
} from "recharts";
import { useAuth } from "@/providers/AuthProvider";

type Tab = "all" | "inactive" | "waitlist" | "special";

export default function ClientsPage() {
    const { user } = useAuth();
    const [tab, setTab] = useState<Tab>("all");
    const [sort, setSort] = useState("client_code");
    const [direction, setDirection] = useState<"asc" | "desc">("asc");
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const queryClient = useQueryClient();

    const { data, isLoading, isError } = useQuery<ClientsData>({
        queryKey: ["clients", sort, direction],
        queryFn: () =>
            api
                .get(ClientActions.index.url(), { params: { sort, direction } })
                .then((r) => r.data),
    });

    const deleteMutation = useMutation({
        mutationFn: (id: number) => api.delete(ClientActions.destroy.url(id)),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["clients"] });
            setDeletingId(null);
        },
    });

    const handleSort = (field: string) => {
        if (sort === field) {
            setDirection(direction === "asc" ? "desc" : "asc");
        } else {
            setSort(field);
            setDirection("asc");
        }
    };

    const tabClients = (): Client[] => {
        if (!data) {
            return [];
        }
        // If admin, use allClients for "all" tab and all* for others
        const isAdmin = user && (user.admin === true || user.admin === 1);
        if (isAdmin) {
            switch (tab) {
                case "inactive":
                    return data.allInactiveClients?.data ?? [];
                case "waitlist":
                    return data.allWaitlistClients?.data ?? [];
                case "special":
                    return data.allSpecialSessionClients?.data ?? [];
                default:
                    return data.allClients?.data ?? [];
            }
        } else {
            switch (tab) {
                case "inactive":
                    return data.inactiveClients?.data ?? [];
                case "waitlist":
                    return data.waitlistClients?.data ?? [];
                case "special":
                    return data.specialSessionsClients?.data ?? [];
                default:
                    return data.clients?.data ?? [];
            }
        }
    };

    const tabs: { key: Tab; label: string }[] = [
        { key: "all", label: "All" },
        { key: "inactive", label: "Inactive" },
        { key: "waitlist", label: "Waitlist" },
        { key: "special", label: "Special Sessions" },
    ];

    const isAdmin = user && (user.admin === true || user.admin === 1);
    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                    Clients
                </h1>
                <Link href="/clients/create">
                    <Button size="sm">+ New Client</Button>
                </Link>
            </div>

            {/* Charts row */}
            {data &&
                (() => {
                    const total = isAdmin
                        ? (data.allClients?.total ?? 0)
                        : (data.clients?.total ?? 0);
                    const inactive = isAdmin
                        ? (data.allInactiveClients?.total ?? 0)
                        : (data.inactiveClients?.total ?? 0);
                    const waitlist = isAdmin
                        ? (data.allWaitlistClients?.total ?? 0)
                        : (data.waitlistClients?.total ?? 0);
                    const special = isAdmin
                        ? (data.allSpecialSessionClients?.total ?? 0)
                        : (data.specialSessionsClients?.total ?? 0);
                    const active = Math.max(
                        0,
                        total - inactive - waitlist - special,
                    );
                    const attended = isAdmin
                        ? (data.allAttendedSessions ?? 0)
                        : (data.attendedSessions ?? 0);
                    const noShows = isAdmin
                        ? (data.allMissedSessions ?? 0)
                        : (data.missedSessions ?? 0);
                    const attendanceData = [
                        { name: "Attended", value: attended },
                        { name: "No-Shows", value: noShows },
                    ];
                    const ATTENDANCE_COLORS = ["#22c55e", "#ef4444"];
                    return (
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                                <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                                    Client Distribution
                                </p>
                                <DonutChart
                                    height={200}
                                    colors={[
                                        "#22c55e",
                                        "#ef4444",
                                        "#f59e0b",
                                        "#8b5cf6",
                                    ]}
                                    data={[
                                        { name: "Active", value: active },
                                        { name: "Inactive", value: inactive },
                                        { name: "Waitlist", value: waitlist },
                                        { name: "Special", value: special },
                                    ]}
                                />
                            </div>
                            <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                                <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                                    Session Attendance
                                </p>
                                <ResponsiveContainer width="100%" height={200}>
                                    <BarChart
                                        data={attendanceData}
                                        margin={{
                                            top: 8,
                                            right: 8,
                                            left: -20,
                                            bottom: 0,
                                        }}
                                    >
                                        <XAxis
                                            dataKey="name"
                                            tick={{ fontSize: 12 }}
                                        />
                                        <YAxis
                                            allowDecimals={false}
                                            tick={{ fontSize: 12 }}
                                        />
                                        <Tooltip
                                            cursor={false}
                                            formatter={(v) =>
                                                (v as number).toLocaleString()
                                            }
                                        />
                                        <Bar
                                            dataKey="value"
                                            radius={[4, 4, 0, 0]}
                                        >
                                            {attendanceData.map((_, i) => (
                                                <Cell
                                                    key={i}
                                                    fill={ATTENDANCE_COLORS[i]}
                                                />
                                            ))}
                                        </Bar>
                                    </BarChart>
                                </ResponsiveContainer>
                            </div>
                        </div>
                    );
                })()}

            {/* Tabs */}
            <PageTabs tabs={tabs} activeTab={tab} onChange={setTab} />

            {isLoading && (
                <div className="flex justify-center py-16">
                    <Spinner className="h-8 w-8" />
                </div>
            )}

            {isError && (
                <div className="rounded-md bg-red-50 p-4 text-red-700 text-sm">
                    Failed to load clients.
                </div>
            )}

            {!isLoading && !isError && (
                <DataTable
                    colSpan={5}
                    isEmpty={tabClients().length === 0}
                    emptyMessage="No clients found."
                    sort={sort}
                    direction={direction}
                    onSort={handleSort}
                    columns={[
                        { label: "Code", sortKey: "client_code" },
                        { label: "Name", sortKey: "legal_name" },
                        {
                            label: "Email",
                            sortKey: "email",
                            className: "hidden sm:table-cell",
                        },
                        { label: "Status" },
                        { label: "Actions", className: "text-right" },
                    ]}
                >
                    {tabClients().map((client) => (
                        <tr
                            key={client.id}
                            className="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        >
                            <td className="px-4 py-3 text-sm font-mono text-gray-600 dark:text-gray-400">
                                {client.client_code}
                            </td>
                            <td className="px-4 py-3">
                                <p className="text-sm font-medium text-gray-900 dark:text-white">
                                    {client.preferred_name ?? client.legal_name}
                                </p>
                                {client.preferred_name && (
                                    <p className="text-xs text-gray-400 dark:text-gray-500">
                                        {client.legal_name}
                                    </p>
                                )}
                            </td>
                            <td className="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                {client.email ?? "—"}
                            </td>
                            <td className="px-4 py-3">
                                <div className="flex flex-wrap gap-1">
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
                                    {client.waitlist === 1 && (
                                        <Badge variant="yellow">Waitlist</Badge>
                                    )}
                                    {client.special_sessions > 0 && (
                                        <Badge variant="blue">Special</Badge>
                                    )}
                                </div>
                            </td>
                            <td className="px-4 py-3 text-right">
                                <div className="flex justify-end gap-2">
                                    <Link
                                        href={`/clients/${client.id}`}
                                        className="text-xs text-indigo-600 hover:text-indigo-900 font-medium"
                                    >
                                        View
                                    </Link>
                                    <Link
                                        href={`/clients/${client.id}/edit`}
                                        className="text-xs text-gray-600 hover:text-gray-900 font-medium"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        onClick={() => setDeletingId(client.id)}
                                        className="text-xs text-red-500 hover:text-red-700 font-medium"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    ))}
                </DataTable>
            )}

            {/* Delete confirmation modal */}
            <Modal
                isOpen={deletingId !== null}
                onClose={() => setDeletingId(null)}
                title="Delete Client"
                footer={
                    <>
                        <Button
                            variant="secondary"
                            onClick={() => setDeletingId(null)}
                        >
                            Cancel
                        </Button>
                        <Button
                            variant="danger"
                            loading={deleteMutation.isPending}
                            onClick={() =>
                                deletingId && deleteMutation.mutate(deletingId)
                            }
                        >
                            Delete
                        </Button>
                    </>
                }
            >
                <p className="text-sm text-gray-600">
                    Are you sure you want to delete this client? This action
                    cannot be undone.
                </p>
            </Modal>
        </div>
    );
}
