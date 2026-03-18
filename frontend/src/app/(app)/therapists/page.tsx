"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import { TherapistsData, User } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";
import Modal from "@/components/ui/Modal";

type Tab = "all" | "active" | "inactive";

export default function TherapistsPage() {
    const [tab, setTab] = useState<Tab>("all");
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const queryClient = useQueryClient();

    const { data, isLoading, isError } = useQuery<TherapistsData>({
        queryKey: ["therapists"],
        queryFn: () => api.get("/api/therapists").then((r) => r.data),
    });

    const deleteMutation = useMutation({
        mutationFn: (id: number) => api.delete(`/api/therapists/${id}`),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ["therapists"] });
            setDeletingId(null);
        },
    });

    const tabData = (): User[] => {
        if (!data) {
            return [];
        }
        switch (tab) {
            case "active":
                return data.activeTherapists?.data ?? [];
            case "inactive":
                return data.inactiveTherapists?.data ?? [];
            default:
                return data.therapists?.data ?? [];
        }
    };

    const tabs: { key: Tab; label: string }[] = [
        { key: "all", label: "All" },
        { key: "active", label: "Active" },
        { key: "inactive", label: "Inactive" },
    ];

    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-900">Therapists</h1>
            </div>

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
                            {data && (
                                <span className="ml-1.5 text-xs text-gray-400">
                                    (
                                    {t.key === "all"
                                        ? data.therapists?.total
                                        : t.key === "active"
                                          ? data.activeTherapists?.total
                                          : data.inactiveTherapists?.total}
                                    )
                                </span>
                            )}
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
                    Failed to load therapists.
                </div>
            )}

            {!isLoading && !isError && (
                <div className="bg-white rounded-lg border border-gray-200 shadow-sm overflow-x-auto">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Email
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
                            {tabData().length === 0 && (
                                <tr>
                                    <td
                                        colSpan={4}
                                        className="px-4 py-8 text-center text-sm text-gray-400"
                                    >
                                        No therapists found.
                                    </td>
                                </tr>
                            )}
                            {tabData().map((therapist) => (
                                <tr
                                    key={therapist.id}
                                    className="hover:bg-gray-50 transition-colors"
                                >
                                    <td className="px-4 py-3">
                                        <p className="text-sm font-medium text-gray-900">
                                            {therapist.preferred_name ??
                                                therapist.name}
                                        </p>
                                        {therapist.preferred_name && (
                                            <p className="text-xs text-gray-400">
                                                {therapist.name}
                                            </p>
                                        )}
                                    </td>
                                    <td className="px-4 py-3 text-sm text-gray-500 hidden sm:table-cell">
                                        {therapist.email}
                                    </td>
                                    <td className="px-4 py-3">
                                        <Badge
                                            variant={
                                                therapist.active_status === 0
                                                    ? "green"
                                                    : "red"
                                            }
                                        >
                                            {therapist.active_status === 0
                                                ? "Active"
                                                : "Inactive"}
                                        </Badge>
                                    </td>
                                    <td className="px-4 py-3 text-right">
                                        <div className="flex justify-end gap-2">
                                            <Link
                                                href={`/therapists/${therapist.id}`}
                                                className="text-xs text-indigo-600 hover:text-indigo-900 font-medium"
                                            >
                                                View
                                            </Link>
                                            <Link
                                                href={`/therapists/${therapist.id}/edit`}
                                                className="text-xs text-gray-600 hover:text-gray-900 font-medium"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                onClick={() =>
                                                    setDeletingId(therapist.id)
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
                title="Delete Therapist"
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
                    Are you sure you want to delete this therapist? This action
                    cannot be undone.
                </p>
            </Modal>
        </div>
    );
}
