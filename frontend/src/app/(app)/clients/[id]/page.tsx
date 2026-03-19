"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import { use } from "react";
import api from "@/lib/api";
import * as ClientActions from "@/actions/App/Http/Controllers/Api/ClientController";
import * as SessionActions from "@/actions/App/Http/Controllers/Api/TherapySessionController";
import { Client, TherapySession } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";
import DataTable from "@/components/ui/DataTable";
import Modal from "@/components/ui/Modal";

export default function ClientShowPage({
    params,
}: {
    params: Promise<{ id: string }>;
}) {
    const { id } = use(params);
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const queryClient = useQueryClient();

    const deleteMutation = useMutation({
        mutationFn: (sessionId: number) =>
            api.delete(SessionActions.destroy.url(sessionId)),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["client", id] });
            setDeletingId(null);
        },
    });

    const { data, isLoading, isError } = useQuery<{
        client: Client;
        therapySessions: TherapySession[];
        attendedSessions: TherapySession[];
    }>({
        queryKey: ["client", id],
        queryFn: () => api.get(ClientActions.show.url(id)).then((r) => r.data),
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
                Failed to load client.
            </div>
        );
    }

    const { client, attendedSessions } = data;
    const totalSessions = attendedSessions.length;
    const noShows = attendedSessions.filter(
        (s) => s.attendance === "no-show",
    ).length;

    return (
        <div className="max-w-3xl mx-auto space-y-6">
            <div className="flex items-center justify-between">
                <div className="flex items-center gap-4">
                    <Link
                        href="/clients"
                        className="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                    >
                        0 Clients
                    </Link>
                    <h1 className="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {client.preferred_name ?? client.legal_name}
                    </h1>
                </div>
                <Link href={`/clients/${id}/edit`}>
                    <Button variant="secondary" size="sm">
                        Edit
                    </Button>
                </Link>
            </div>

            {/* Client details */}
            <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <div className="flex items-start justify-between mb-4">
                    <div>
                        <p className="text-xs font-mono text-gray-400 dark:text-gray-500">
                            {client.client_code}
                        </p>
                        {client.preferred_name && (
                            <p className="text-sm text-gray-500 dark:text-gray-400">
                                Legal: {client.legal_name}
                            </p>
                        )}
                    </div>
                    <div className="flex gap-2">
                        <Badge variant={client.status === 0 ? "green" : "red"}>
                            {client.status === 0 ? "Active" : "Inactive"}
                        </Badge>
                        {client.waitlist === 1 && (
                            <Badge variant="yellow">Waitlist</Badge>
                        )}
                        {client.special_sessions > 0 && (
                            <Badge variant="blue">Special</Badge>
                        )}
                    </div>
                </div>

                <dl className="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Email
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {client.email ?? "—"}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Phone
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {client.phone ?? "—"}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Category
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {client.category ?? "—"}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Client Contribution
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {client.client_contribution != null
                                ? `$${client.client_contribution}`
                                : "—"}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Therapist
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {client.user
                                ? (client.user.preferred_name ??
                                  client.user.name)
                                : "Unassigned"}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Joined
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {new Date(client.created_at).toLocaleDateString()}
                        </dd>
                    </div>
                </dl>
            </div>

            {/* Session stats */}
            <div className="grid grid-cols-3 gap-4">
                <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-4 text-center">
                    <p className="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        {totalSessions}
                    </p>
                    <p className="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Total Sessions
                    </p>
                </div>
                <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-4 text-center">
                    <p className="text-2xl font-bold text-green-600 dark:text-green-400">
                        {totalSessions - noShows}
                    </p>
                    <p className="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Attended
                    </p>
                </div>
                <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-4 text-center">
                    <p className="text-2xl font-bold text-red-600 dark:text-red-400">
                        {noShows}
                    </p>
                    <p className="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        No-Shows
                    </p>
                </div>
            </div>

            {/* Session history */}
            <div>
                <div className="flex items-center justify-between mb-3">
                    <h2 className="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Session History
                    </h2>
                    <Link href={`/sessions/create?client_id=${id}`}>
                        <Button size="sm">+ Add Session</Button>
                    </Link>
                </div>
                <DataTable
                    colSpan={5}
                    isEmpty={attendedSessions.length === 0}
                    emptyMessage="No sessions recorded."
                    columns={[
                        { label: "Date" },
                        { label: "Attendance" },
                        { label: "Cost" },
                        { label: "Notes", className: "hidden sm:table-cell" },
                        { label: "Actions", className: "text-right" },
                    ]}
                >
                    {attendedSessions.map((session) => (
                        <tr
                            key={session.id}
                            className="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        >
                            <td className="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {session.session_date
                                    ? new Date(
                                          session.session_date,
                                      ).toLocaleDateString()
                                    : new Date(
                                          session.created_at,
                                      ).toLocaleDateString()}
                            </td>
                            <td className="px-4 py-3">
                                <Badge
                                    variant={
                                        session.attendance === "attended"
                                            ? "green"
                                            : session.attendance === "no-show"
                                              ? "red"
                                              : "gray"
                                    }
                                >
                                    {session.attendance ?? "—"}
                                </Badge>
                            </td>
                            <td className="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {session.session_cost != null
                                    ? `$${session.session_cost}`
                                    : "—"}
                            </td>
                            <td className="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                                {session.notes ?? "—"}
                            </td>
                            <td className="px-4 py-3 text-right">
                                <div className="flex justify-end gap-2">
                                    <Link
                                        href={`/sessions/${session.id}`}
                                        className="text-xs text-indigo-600 hover:text-indigo-900 font-medium"
                                    >
                                        View
                                    </Link>
                                    <Link
                                        href={`/sessions/${session.id}/edit`}
                                        className="text-xs text-blue-600 hover:text-blue-900 font-medium"
                                    >
                                        Edit
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
            </div>

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
