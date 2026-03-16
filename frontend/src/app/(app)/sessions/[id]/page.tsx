"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import { use } from "react";
import api from "@/lib/api";
import { TherapySession } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";

export default function SessionShowPage({
    params,
}: {
    params: Promise<{ id: string }>;
}) {
    const { id } = use(params);
    const queryClient = useQueryClient();
    const [editing, setEditing] = useState(false);
    const [form, setForm] = useState<{
        attendance: string;
        session_cost: string;
        notes: string;
        session_date: string;
    } | null>(null);

    const { data, isLoading, isError } = useQuery<{ session: TherapySession }>({
        queryKey: ["session", id],
        queryFn: () => api.get(`/api/sessions/${id}`).then((r) => r.data),
        select: (d) => {
            if (!form && d.session) {
                setForm({
                    attendance: d.session.attendance ?? "attended",
                    session_cost: d.session.session_cost?.toString() ?? "",
                    notes: d.session.notes ?? "",
                    session_date:
                        d.session.session_date ??
                        d.session.created_at.split("T")[0],
                });
            }
            return d;
        },
    });

    const updateMutation = useMutation({
        mutationFn: (payload: typeof form) =>
            api.patch(`/api/sessions/${id}`, payload),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["session", id] });
            setEditing(false);
        },
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
                Failed to load session.
            </div>
        );
    }

    const { session } = data;

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

    return (
        <div className="max-w-2xl mx-auto space-y-6">
            <div className="flex items-center justify-between">
                <div className="flex items-center gap-4">
                    <Link
                        href="/sessions"
                        className="text-sm text-gray-500 hover:text-gray-700"
                    >
                        ← Sessions
                    </Link>
                    <h1 className="text-2xl font-bold text-gray-900">
                        Session #{session.id}
                    </h1>
                </div>
                {!editing && (
                    <Button
                        variant="secondary"
                        size="sm"
                        onClick={() => setEditing(true)}
                    >
                        Edit
                    </Button>
                )}
            </div>

            {editing && form ? (
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        updateMutation.mutate(form);
                    }}
                    className="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-4"
                >
                    <h2 className="text-base font-semibold text-gray-700">
                        Edit Session
                    </h2>

                    <div className="grid grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Attendance
                            </label>
                            <select
                                value={form.attendance}
                                onChange={(e) =>
                                    setForm(
                                        (p) =>
                                            p && {
                                                ...p,
                                                attendance: e.target.value,
                                            },
                                    )
                                }
                                className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="attended">Attended</option>
                                <option value="no-show">No-show</option>
                                <option value="missed">Missed</option>
                            </select>
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Date
                            </label>
                            <input
                                type="date"
                                value={form.session_date}
                                onChange={(e) =>
                                    setForm(
                                        (p) =>
                                            p && {
                                                ...p,
                                                session_date: e.target.value,
                                            },
                                    )
                                }
                                className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Session Cost ($)
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            value={form.session_cost}
                            onChange={(e) =>
                                setForm(
                                    (p) =>
                                        p && {
                                            ...p,
                                            session_cost: e.target.value,
                                        },
                                )
                            }
                            className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Notes
                        </label>
                        <textarea
                            value={form.notes}
                            onChange={(e) =>
                                setForm(
                                    (p) => p && { ...p, notes: e.target.value },
                                )
                            }
                            rows={3}
                            className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>

                    <div className="flex justify-end gap-3">
                        <Button
                            variant="secondary"
                            type="button"
                            onClick={() => setEditing(false)}
                        >
                            Cancel
                        </Button>
                        <Button
                            type="submit"
                            loading={updateMutation.isPending}
                        >
                            Save
                        </Button>
                    </div>
                </form>
            ) : (
                <div className="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <dl className="grid grid-cols-2 gap-4">
                        <div>
                            <dt className="text-xs font-medium text-gray-500">
                                Client
                            </dt>
                            <dd className="text-sm text-gray-900 mt-0.5">
                                {session.client ? (
                                    <Link
                                        href={`/clients/${session.client_id}`}
                                        className="text-indigo-600 hover:underline"
                                    >
                                        {session.client.preferred_name ??
                                            session.client.legal_name}
                                    </Link>
                                ) : (
                                    `Client #${session.client_id}`
                                )}
                            </dd>
                        </div>
                        <div>
                            <dt className="text-xs font-medium text-gray-500">
                                Attendance
                            </dt>
                            <dd className="mt-0.5">
                                {attendanceBadge(session.attendance)}
                            </dd>
                        </div>
                        <div>
                            <dt className="text-xs font-medium text-gray-500">
                                Date
                            </dt>
                            <dd className="text-sm text-gray-900 mt-0.5">
                                {session.session_date
                                    ? new Date(
                                          session.session_date,
                                      ).toLocaleDateString()
                                    : new Date(
                                          session.created_at,
                                      ).toLocaleDateString()}
                            </dd>
                        </div>
                        <div>
                            <dt className="text-xs font-medium text-gray-500">
                                Cost
                            </dt>
                            <dd className="text-sm text-gray-900 mt-0.5">
                                {session.session_cost != null
                                    ? `$${session.session_cost}`
                                    : "—"}
                            </dd>
                        </div>
                        <div>
                            <dt className="text-xs font-medium text-gray-500">
                                Special
                            </dt>
                            <dd className="text-sm text-gray-900 mt-0.5">
                                {session.special === 1 ? (
                                    <Badge variant="blue">Yes</Badge>
                                ) : (
                                    "No"
                                )}
                            </dd>
                        </div>
                    </dl>
                    {session.notes && (
                        <div className="mt-4 pt-4 border-t border-gray-100">
                            <dt className="text-xs font-medium text-gray-500 mb-1">
                                Notes
                            </dt>
                            <p className="text-sm text-gray-700">
                                {session.notes}
                            </p>
                        </div>
                    )}
                </div>
            )}
        </div>
    );
}
