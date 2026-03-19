"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import * as SessionActions from "@/actions/App/Http/Controllers/Api/TherapySessionController";
import { PaginatedResponse, TherapySession } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";
import Modal from "@/components/ui/Modal";
import StatCard from "@/components/ui/StatCard";
import DataTable from "@/components/ui/DataTable";
import PageTabs from "@/components/ui/PageTabs";
import DonutChart from "@/components/ui/DonutChart";
import { useAuth } from "@/providers/AuthProvider";

type Tab = "all" | "missed" | "special";

export default function SessionsPage() {
    const { user } = useAuth();
    const [tab, setTab] = useState<Tab>("all");
    const [sort, setSort] = useState("session_date");
    const [direction, setDirection] = useState<"asc" | "desc">("desc");
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const queryClient = useQueryClient();

    const { data, isLoading, isError } = useQuery<{
        sessions: PaginatedResponse<TherapySession>;
        missedSessions: PaginatedResponse<TherapySession>;
        specialSessions: PaginatedResponse<TherapySession>;
        allTherapySessions?: PaginatedResponse<TherapySession>;
        allMissedSessions?: PaginatedResponse<TherapySession>;
        allSpecialSessions?: PaginatedResponse<TherapySession>;
    }>({
        queryKey: ["sessions"],
        queryFn: () => api.get(SessionActions.index.url()).then((r) => r.data),
    });

    const deleteMutation = useMutation({
        mutationFn: (id: number) => api.delete(SessionActions.destroy.url(id)),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["sessions"] });
            setDeletingId(null);
        },
    });

    const tabSessions = (): TherapySession[] => {
        if (!data) {
            return [];
        }
        const isAdmin = user && (user.admin === true || user.admin === 1);
        if (isAdmin) {
            switch (tab) {
                case "missed":
                    return data.allMissedSessions?.data ?? [];
                case "special":
                    return data.allSpecialSessions?.data ?? [];
                default:
                    return data.allTherapySessions?.data ?? [];
            }
        } else {
            switch (tab) {
                case "missed":
                    return data.missedSessions?.data ?? [];
                case "special":
                    return data.specialSessions?.data ?? [];
                default:
                    return data.sessions?.data ?? [];
            }
        }
    };

    const handleSort = (field: string) => {
        if (sort === field) {
            setDirection(direction === "asc" ? "desc" : "asc");
        } else {
            setSort(field);
            setDirection("asc");
        }
    };

    const sortedSessions = (): TherapySession[] => {
        const rows = tabSessions();
        return [...rows].sort((a, b) => {
            let aVal: string | number = "";
            let bVal: string | number = "";
            switch (sort) {
                case "client_name":
                    aVal = (
                        a.client?.preferred_name ??
                        a.client?.legal_name ??
                        ""
                    ).toLowerCase();
                    bVal = (
                        b.client?.preferred_name ??
                        b.client?.legal_name ??
                        ""
                    ).toLowerCase();
                    break;
                case "session_date":
                    aVal = a.session_date ?? a.created_at;
                    bVal = b.session_date ?? b.created_at;
                    break;
                case "attendance":
                    aVal = a.attendance ?? "";
                    bVal = b.attendance ?? "";
                    break;
                case "session_cost":
                    aVal = a.session_cost ?? -1;
                    bVal = b.session_cost ?? -1;
                    break;
            }
            if (aVal < bVal) {
                return direction === "asc" ? -1 : 1;
            }
            if (aVal > bVal) {
                return direction === "asc" ? 1 : -1;
            }
            return 0;
        });
    };

    const attendanceBadge = (attendance: TherapySession["attendance"]) => {
        switch (attendance) {
            case "attended":
                return <Badge variant="green">Attended</Badge>;
            case "no-show":
                return <Badge variant="red">No-show</Badge>;
            case "missed":
                return <Badge variant="yellow">Missed</Badge>;
            default:
                return <Badge variant="gray">Pending</Badge>;
        }
    };

    const tabs: { key: Tab; label: string }[] = [
        { key: "all", label: "All Sessions" },
        { key: "missed", label: "No-shows" },
        { key: "special", label: "Special" },
    ];

    const isAdmin = user && (user.admin === true || user.admin === 1);
    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                    Sessions
                </h1>
                <Link href="/sessions/create">
                    <Button size="sm">+ New Session</Button>
                </Link>
            </div>

            {/* Stats row */}
            {data &&
                (() => {
                    const allTotal = isAdmin
                        ? (data.allTherapySessions?.total ?? 0)
                        : (data.sessions?.total ?? 0);
                    const noShowTotal = isAdmin
                        ? (data.allMissedSessions?.total ?? 0)
                        : (data.missedSessions?.total ?? 0);
                    const specialTotal = isAdmin
                        ? (data.allSpecialSessions?.total ?? 0)
                        : (data.specialSessions?.total ?? 0);
                    const allRows = isAdmin
                        ? (data.allTherapySessions?.data ?? [])
                        : (data.sessions?.data ?? []);
                    const attended = allRows.filter(
                        (s) => s.attendance === "attended",
                    ).length;
                    const noShow = allRows.filter(
                        (s) => s.attendance === "no-show",
                    ).length;
                    const missed = allRows.filter(
                        (s) => s.attendance === "missed",
                    ).length;
                    const pending = allRows.filter((s) => !s.attendance).length;
                    return (
                        <div className="grid grid-cols-1 lg:grid-cols-4 gap-4">
                            <div className="lg:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <StatCard
                                    label="All Sessions"
                                    value={allTotal}
                                    color="indigo"
                                />
                                <StatCard
                                    label="No-Shows"
                                    value={noShowTotal}
                                    color="red"
                                />
                                <StatCard
                                    label="Special Sessions"
                                    value={specialTotal}
                                    color="purple"
                                />
                            </div>
                            <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
                                <p className="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Attendance Breakdown
                                </p>
                                <DonutChart
                                    height={160}
                                    data={[
                                        { name: "Attended", value: attended },
                                        { name: "No-Show", value: noShow },
                                        { name: "Missed", value: missed },
                                        { name: "Pending", value: pending },
                                    ]}
                                />
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
                    Failed to load sessions.
                </div>
            )}

            {!isLoading && !isError && (
                <DataTable
                    colSpan={5}
                    isEmpty={tabSessions().length === 0}
                    emptyMessage="No sessions found."
                    sort={sort}
                    direction={direction}
                    onSort={handleSort}
                    columns={[
                        { label: "Client", sortKey: "client_name" },
                        {
                            label: "Date",
                            sortKey: "session_date",
                            className: "hidden sm:table-cell",
                        },
                        { label: "Attendance", sortKey: "attendance" },
                        {
                            label: "Cost",
                            sortKey: "session_cost",
                            className: "hidden sm:table-cell",
                        },
                        { label: "Actions", className: "text-right" },
                    ]}
                >
                    {sortedSessions().map((session) => (
                        <tr
                            key={session.id}
                            className="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        >
                            <td className="px-4 py-3">
                                {session.client ? (
                                    <div>
                                        <p className="text-sm font-medium text-gray-900 dark:text-white">
                                            {session.client.preferred_name ??
                                                session.client.legal_name}
                                        </p>
                                        <p className="text-xs text-gray-400 dark:text-gray-500">
                                            {session.client.client_code}
                                        </p>
                                    </div>
                                ) : (
                                    <span className="text-sm text-gray-400 dark:text-gray-500">
                                        Client #{session.client_id}
                                    </span>
                                )}
                            </td>
                            <td className="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                {session.session_date
                                    ? new Date(
                                          session.session_date,
                                      ).toLocaleDateString()
                                    : new Date(
                                          session.created_at,
                                      ).toLocaleDateString()}
                            </td>
                            <td className="px-4 py-3">
                                <div className="flex items-center gap-1">
                                    {attendanceBadge(session.attendance)}
                                    {session.special === 1 && (
                                        <Badge variant="blue">Special</Badge>
                                    )}
                                </div>
                            </td>
                            <td className="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                {session.session_cost != null
                                    ? `$${session.session_cost}`
                                    : "—"}
                            </td>
                            <td className="px-4 py-3 text-right">
                                <div className="flex justify-end gap-2">
                                    <Link
                                        href={`/sessions/${session.id}`}
                                        className="text-xs text-indigo-600 hover:text-indigo-900 font-medium"
                                    >
                                        View
                                    </Link>
                                    <button
                                        onClick={() =>
                                            setDeletingId(session.id)
                                        }
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

            <Modal
                isOpen={deletingId !== null}
                onClose={() => setDeletingId(null)}
                title="Delete Session"
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
                <p className="text-sm text-gray-600 dark:text-gray-400">
                    Are you sure you want to delete this session? This action
                    cannot be undone.
                </p>
            </Modal>
        </div>
    );
}
