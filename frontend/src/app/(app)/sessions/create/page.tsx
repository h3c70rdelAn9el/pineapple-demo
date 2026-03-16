"use client";

import { useState } from "react";
import { useRouter, useSearchParams } from "next/navigation";
import { useQuery, useMutation } from "@tanstack/react-query";
import Link from "next/link";
import { Suspense } from "react";
import api from "@/lib/api";
import Button from "@/components/ui/Button";
import Spinner from "@/components/ui/Spinner";
import { Client, User } from "@/types";

interface SessionFormData {
    client_id: string;
    user_id: string;
    attendance: string;
    session_cost: string;
    session_date: string;
    notes: string;
    special: boolean;
}

function CreateSessionForm() {
    const router = useRouter();
    const searchParams = useSearchParams();
    const defaultClientId = searchParams.get("client_id") ?? "";
    const [error, setError] = useState<string | null>(null);
    const [form, setForm] = useState<SessionFormData>({
        client_id: defaultClientId,
        user_id: "",
        attendance: "attended",
        session_cost: "",
        session_date: new Date().toISOString().split("T")[0],
        notes: "",
        special: false,
    });

    const { data: createData, isLoading: loadingForm } = useQuery({
        queryKey: ["sessions-create"],
        queryFn: () =>
            api
                .get("/api/clients", { params: { per_page: 100 } })
                .then((r) => r.data),
    });

    const createMutation = useMutation({
        mutationFn: (data: SessionFormData) => api.post("/api/sessions", data),
        onSuccess: () => router.push("/sessions"),
        onError: (err: {
            response?: {
                data?: { message?: string; errors?: Record<string, string[]> };
            };
        }) => {
            const msg = err.response?.data?.errors
                ? Object.values(err.response.data.errors).flat().join(" ")
                : (err.response?.data?.message ?? "Failed to create session.");
            setError(msg);
        },
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        createMutation.mutate(form);
    };

    const set =
        (field: keyof SessionFormData) =>
        (
            e: React.ChangeEvent<
                HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement
            >,
        ) => {
            const value =
                e.target instanceof HTMLInputElement &&
                e.target.type === "checkbox"
                    ? e.target.checked
                    : e.target.value;
            setForm((prev) => ({ ...prev, [field]: value }));
        };

    if (loadingForm) {
        return (
            <div className="flex justify-center py-24">
                <Spinner className="h-8 w-8" />
            </div>
        );
    }

    const clients: Client[] =
        createData?.clients?.data ?? createData?.allClients?.data ?? [];
    const therapists: User[] = createData?.therapists ?? [];

    return (
        <div className="max-w-2xl mx-auto space-y-6">
            <div className="flex items-center gap-4">
                <Link
                    href="/sessions"
                    className="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Sessions
                </Link>
                <h1 className="text-2xl font-bold text-gray-900">
                    New Session
                </h1>
            </div>

            {error && (
                <div className="rounded-md bg-red-50 p-3 text-sm text-red-700 border border-red-200">
                    {error}
                </div>
            )}

            <form
                onSubmit={handleSubmit}
                className="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-5"
            >
                <div>
                    <label
                        htmlFor="client_id"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Client *
                    </label>
                    <select
                        id="client_id"
                        value={form.client_id}
                        onChange={set("client_id")}
                        required
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">Select a client</option>
                        {clients.map((c) => (
                            <option key={c.id} value={c.id}>
                                {c.client_code} —{" "}
                                {c.preferred_name ?? c.legal_name}
                            </option>
                        ))}
                    </select>
                </div>

                <div>
                    <label
                        htmlFor="user_id"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Therapist
                    </label>
                    <select
                        id="user_id"
                        value={form.user_id}
                        onChange={set("user_id")}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">None</option>
                        {therapists.map((t) => (
                            <option key={t.id} value={t.id}>
                                {t.preferred_name ?? t.name}
                            </option>
                        ))}
                    </select>
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            htmlFor="attendance"
                            className="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Attendance
                        </label>
                        <select
                            id="attendance"
                            value={form.attendance}
                            onChange={set("attendance")}
                            className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="attended">Attended</option>
                            <option value="no-show">No-show</option>
                            <option value="missed">Missed</option>
                        </select>
                    </div>
                    <div>
                        <label
                            htmlFor="session_date"
                            className="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Session Date
                        </label>
                        <input
                            id="session_date"
                            type="date"
                            value={form.session_date}
                            onChange={set("session_date")}
                            className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>

                <div>
                    <label
                        htmlFor="session_cost"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Session Cost ($)
                    </label>
                    <input
                        id="session_cost"
                        type="number"
                        step="0.01"
                        value={form.session_cost}
                        onChange={set("session_cost")}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <div>
                    <label
                        htmlFor="notes"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Notes
                    </label>
                    <textarea
                        id="notes"
                        value={form.notes}
                        onChange={set("notes")}
                        rows={3}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <label className="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input
                        type="checkbox"
                        checked={form.special}
                        onChange={set("special")}
                        className="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />
                    Special session
                </label>

                <div className="flex justify-end gap-3 pt-2">
                    <Link href="/sessions">
                        <Button variant="secondary" type="button">
                            Cancel
                        </Button>
                    </Link>
                    <Button type="submit" loading={createMutation.isPending}>
                        Create Session
                    </Button>
                </div>
            </form>
        </div>
    );
}

export default function CreateSessionPage() {
    return (
        <Suspense
            fallback={
                <div className="flex justify-center py-24">
                    <Spinner className="h-8 w-8" />
                </div>
            }
        >
            <CreateSessionForm />
        </Suspense>
    );
}
