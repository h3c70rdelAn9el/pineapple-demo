"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import { PaginatedResponse, TherapySession } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";
import Modal from "@/components/ui/Modal";
import StatCard from "@/components/ui/StatCard";
import { useAuth } from "@/providers/AuthProvider";

type Tab = "all" | "missed" | "special";

export default function SessionsPage() {
    const { user } = useAuth();
    const [tab, setTab] = useState<Tab>("all");
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
        queryFn: () => api.get("/api/sessions").then((r) => r.data),
    });

    const deleteMutation = useMutation({
        mutationFn: (id: number) => api.delete(`/api/sessions/${id}`),
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
                <h1 className="text-2xl font-bold text-gray-900">Sessions</h1>
                <Link href="/sessions/create">
                    <Button size="sm">+ New Session</Button>
                </Link>
            </div>

            {/* Stats row */}
            {data && (
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <StatCard
                        label="All Sessions"
                        value={isAdmin ? data.allTherapySessions?.total ?? 0 : data.sessions?.total ?? 0}
                        color="indigo"
                    />
                    <StatCard
                        label="No-Shows"
                        value={isAdmin ? data.allMissedSessions?.total ?? 0 : data.missedSessions?.total ?? 0}
                        color="red"
                    />
                    <StatCard
                        label="Special Sessions"
                        value={isAdmin ? data.allSpecialSessions?.total ?? 0 : data.specialSessions?.total ?? 0}
                        color="purple"
                    />
                </div>
            )}

            {/* Tabs */}
            <div className="border-b border-gray-200">
                <nav className="flex space-x-4 -mb-px">
                    {tabs.map((t) => (
                        <button
                            key={t.key}
                            onClick={() => setTab(t.key)}
                            className={`py-2 px-1 border-b-2 text-sm font-medium transition-colors ${
                                tab === t.key
                                    ? "border-indigo-500 text-indigo-600"
                                    : "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            }`}
                        >
                            {t.label}
                        </button>
                    ))}
                </nav>
            </div>

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
                <div className="bg-white rounded-lg border border-gray-200 shadow-sm overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Client
                                </th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Date
                                </th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Attendance
                                </th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Cost
                                </th>
                                <th className="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100">
                            {tabSessions().length === 0 && (
                                <tr>
                                    <td
                                        colSpan={5}
                                        className="px-4 py-8 text-center text-sm text-gray-400"
                                    >
                                        No sessions found.
                                    </td>
                                </tr>
                            )}
                            {tabSessions().map((session) => (
                                <tr
                                    key={session.id}
                                    className="hover:bg-gray-50 transition-colors"
                                >
                                    <td className="px-4 py-3">
                                        {session.client ? (
                                            <div>
                                                <p className="text-sm font-medium text-gray-900">
                                                    {session.client
                                                        .preferred_name ??
                                                        session.client
                                                            .legal_name}
                                                </p>
                                                <p className="text-xs text-gray-400">
                                                    {session.client.client_code}
                                                </p>
                                            </div>
                                        ) : (
                                            <span className="text-sm text-gray-400">
                                                Client #{session.client_id}
                                            </span>
                                        )}
                                    </td>
                                    <td className="px-4 py-3 text-sm text-gray-500 hidden sm:table-cell">
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
                                            {attendanceBadge(
                                                session.attendance,
                                            )}
                                            {session.special === 1 && (
                                                <Badge variant="blue">
                                                    Special
                                                </Badge>
                                            )}
                                        </div>
                                    </td>
                                    <td className="px-4 py-3 text-sm text-gray-500 hidden sm:table-cell">
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
                        </tbody>
                    </table>
                </div>
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
                <p className="text-sm text-gray-600">
                    Are you sure you want to delete this session? This action
                    cannot be undone.
                </p>
            </Modal>
        </div>
    );
}
