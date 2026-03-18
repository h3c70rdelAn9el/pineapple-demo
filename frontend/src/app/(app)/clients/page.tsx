"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import { ClientsData, Client } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";
import Modal from "@/components/ui/Modal";
import StatCard from "@/components/ui/StatCard";

type Tab = "all" | "inactive" | "waitlist" | "special";

export default function ClientsPage() {
    const [tab, setTab] = useState<Tab>("all");
    const [sort, setSort] = useState("client_code");
    const [direction, setDirection] = useState<"asc" | "desc">("asc");
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const queryClient = useQueryClient();

    const { data, isLoading, isError } = useQuery<ClientsData>({
        queryKey: ["clients", sort, direction],
        queryFn: () =>
            api
                .get("/api/clients", { params: { sort, direction } })
                .then((r) => r.data),
    });

    const deleteMutation = useMutation({
        mutationFn: (id: number) => api.delete(`/api/clients/${id}`),
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
    };

    const tabs: { key: Tab; label: string }[] = [
        { key: "all", label: "All" },
        { key: "inactive", label: "Inactive" },
        { key: "waitlist", label: "Waitlist" },
        { key: "special", label: "Special Sessions" },
    ];

    const SortIcon = ({ field }: { field: string }) =>
        sort === field ? (
            <span className="ml-1 text-indigo-500">
                {direction === "asc" ? "↑" : "↓"}
            </span>
        ) : null;

    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-900">Clients</h1>
                <Link href="/clients/create">
                    <Button size="sm">+ New Client</Button>
                </Link>
            </div>

            {/* Stats row */}
            {data && (
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <StatCard
                        label="Total Clients"
                        value={data.clients?.total ?? 0}
                        color="indigo"
                        href="/clients"
                    />
                    <StatCard
                        label="Sessions Attended"
                        value={data.attendedSessions ?? 0}
                        color="green"
                    />
                    <StatCard
                        label="No-Shows"
                        value={data.missedSessions ?? 0}
                        color="red"
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
                    Failed to load clients.
                </div>
            )}

            {!isLoading && !isError && (
                <div className="bg-white rounded-lg border border-gray-200 shadow-sm overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th
                                    className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onClick={() => handleSort("client_code")}
                                >
                                    Code <SortIcon field="client_code" />
                                </th>
                                <th
                                    className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700"
                                    onClick={() => handleSort("legal_name")}
                                >
                                    Name <SortIcon field="legal_name" />
                                </th>
                                <th
                                    className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-700 hidden sm:table-cell"
                                    onClick={() => handleSort("email")}
                                >
                                    Email <SortIcon field="email" />
                                </th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th className="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-100">
                            {tabClients().length === 0 && (
                                <tr>
                                    <td
                                        colSpan={5}
                                        className="px-4 py-8 text-center text-sm text-gray-400"
                                    >
                                        No clients found.
                                    </td>
                                </tr>
                            )}
                            {tabClients().map((client) => (
                                <tr
                                    key={client.id}
                                    className="hover:bg-gray-50 transition-colors"
                                >
                                    <td className="px-4 py-3 text-sm font-mono text-gray-600">
                                        {client.client_code}
                                    </td>
                                    <td className="px-4 py-3">
                                        <p className="text-sm font-medium text-gray-900">
                                            {client.preferred_name ??
                                                client.legal_name}
                                        </p>
                                        {client.preferred_name && (
                                            <p className="text-xs text-gray-400">
                                                {client.legal_name}
                                            </p>
                                        )}
                                    </td>
                                    <td className="px-4 py-3 text-sm text-gray-500 hidden sm:table-cell">
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
                                                <Badge variant="yellow">
                                                    Waitlist
                                                </Badge>
                                            )}
                                            {client.special_sessions > 0 && (
                                                <Badge variant="blue">
                                                    Special
                                                </Badge>
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
                                                onClick={() =>
                                                    setDeletingId(client.id)
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
