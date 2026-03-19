"use client";

import { useState } from "react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import * as TherapistActions from "@/actions/App/Http/Controllers/Api/TherapistController";
import { TherapistsData, User } from "@/types";
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

type Tab = "all" | "active" | "inactive";

export default function TherapistsPage() {
    const [tab, setTab] = useState<Tab>("all");
    const [sort, setSort] = useState("name");
    const [direction, setDirection] = useState<"asc" | "desc">("asc");
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const queryClient = useQueryClient();

    const { data, isLoading, isError } = useQuery<TherapistsData>({
        queryKey: ["therapists"],
        queryFn: () =>
            api.get(TherapistActions.index.url()).then((r) => r.data),
    });

    const deleteMutation = useMutation({
        mutationFn: (id: number) =>
            api.delete(TherapistActions.destroy.url(id)),
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

    const handleSort = (field: string) => {
        if (sort === field) {
            setDirection(direction === "asc" ? "desc" : "asc");
        } else {
            setSort(field);
            setDirection("asc");
        }
    };

    const sortedData = (): User[] => {
        const rows = tabData();
        return [...rows].sort((a, b) => {
            let aVal: string = "";
            let bVal: string = "";
            switch (sort) {
                case "name":
                    aVal = (a.preferred_name ?? a.name).toLowerCase();
                    bVal = (b.preferred_name ?? b.name).toLowerCase();
                    break;
                case "email":
                    aVal = a.email.toLowerCase();
                    bVal = b.email.toLowerCase();
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

    const tabs: { key: Tab; label: string }[] = [
        { key: "all", label: "All" },
        { key: "active", label: "Active" },
        { key: "inactive", label: "Inactive" },
    ];

    return (
        <div className="space-y-6">
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                    Therapists
                </h1>
            </div>

            {/* Charts row */}
            {data && (
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                            Active vs Inactive
                        </p>
                        <DonutChart
                            height={200}
                            colors={["#22c55e", "#ef4444"]}
                            data={[
                                {
                                    name: "Active",
                                    value: data.activeTherapists?.total ?? 0,
                                },
                                {
                                    name: "Inactive",
                                    value: data.inactiveTherapists?.total ?? 0,
                                },
                            ]}
                        />
                    </div>
                    <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <p className="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                            Profile Health
                        </p>
                        {(() => {
                            const profileData = [
                                {
                                    name: "Complete",
                                    value: data.completeTherapists?.total ?? 0,
                                    fill: "#22c55e",
                                },
                                {
                                    name: "Incomplete",
                                    value:
                                        data.incompleteTherapists?.total ?? 0,
                                    fill: "#f59e0b",
                                },
                                {
                                    name: "Unverified",
                                    value:
                                        data.unverifiedTherapists?.total ?? 0,
                                    fill: "#ef4444",
                                },
                            ];
                            return (
                                <ResponsiveContainer width="100%" height={200}>
                                    <BarChart
                                        data={profileData}
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
                                            {profileData.map((entry, i) => (
                                                <Cell
                                                    key={i}
                                                    fill={entry.fill}
                                                />
                                            ))}
                                        </Bar>
                                    </BarChart>
                                </ResponsiveContainer>
                            );
                        })()}
                    </div>
                </div>
            )}

            {/* Tabs */}
            <PageTabs
                tabs={tabs.map((t) => ({
                    ...t,
                    count: data
                        ? t.key === "all"
                            ? data.therapists?.total
                            : t.key === "active"
                              ? data.activeTherapists?.total
                              : data.inactiveTherapists?.total
                        : undefined,
                }))}
                activeTab={tab}
                onChange={setTab}
            />

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
                <DataTable
                    colSpan={4}
                    isEmpty={tabData().length === 0}
                    emptyMessage="No therapists found."
                    sort={sort}
                    direction={direction}
                    onSort={handleSort}
                    columns={[
                        { label: "Name", sortKey: "name" },
                        {
                            label: "Email",
                            sortKey: "email",
                            className: "hidden sm:table-cell",
                        },
                        { label: "Status" },
                        { label: "Actions", className: "text-right" },
                    ]}
                >
                    {sortedData().map((therapist) => (
                        <tr
                            key={therapist.id}
                            className="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        >
                            <td className="px-4 py-3">
                                <p className="text-sm font-medium text-gray-900 dark:text-white">
                                    {therapist.preferred_name ?? therapist.name}
                                </p>
                                {therapist.preferred_name && (
                                    <p className="text-xs text-gray-400 dark:text-gray-500">
                                        {therapist.name}
                                    </p>
                                )}
                            </td>
                            <td className="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 hidden sm:table-cell">
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
                </DataTable>
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
                <p className="text-sm text-gray-600 dark:text-gray-400">
                    Are you sure you want to delete this therapist? This action
                    cannot be undone.
                </p>
            </Modal>
        </div>
    );
}
