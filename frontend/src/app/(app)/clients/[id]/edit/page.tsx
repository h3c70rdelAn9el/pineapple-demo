"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { useQuery, useMutation } from "@tanstack/react-query";
import Link from "next/link";
import { use } from "react";
import api from "@/lib/api";
import Button from "@/components/ui/Button";
import Input from "@/components/ui/Input";
import Spinner from "@/components/ui/Spinner";
import { Client, User } from "@/types";

export default function EditClientPage({
    params,
}: {
    params: Promise<{ id: string }>;
}) {
    const { id } = use(params);
    const router = useRouter();
    const [error, setError] = useState<string | null>(null);
    type ClientForm = Omit<Partial<Client>, "user_id"> & { user_id?: string };
    const [form, setForm] = useState<ClientForm>({});

    const { data: clientData, isLoading: loadingClient } = useQuery<{
        client: Client;
        therapists: User[];
    }>({
        queryKey: ["client-edit", id],
        queryFn: () => api.get(`/api/clients/${id}`).then((r) => r.data),
    });

    const { data: createData } = useQuery({
        queryKey: ["clients-create"],
        queryFn: () => api.get("/api/clients/create").then((r) => r.data),
    });

    useEffect(() => {
        if (clientData?.client) {
            const c = clientData.client;
            setForm({
                ...c,
                user_id: c.user_id?.toString() ?? "",
            });
        }
    }, [clientData]);

    const updateMutation = useMutation({
        mutationFn: (data: ClientForm) => api.put(`/api/clients/${id}`, data),
        onSuccess: () => router.push(`/clients/${id}`),
        onError: (err: {
            response?: {
                data?: { message?: string; errors?: Record<string, string[]> };
            };
        }) => {
            const msg = err.response?.data?.errors
                ? Object.values(err.response.data.errors).flat().join(" ")
                : (err.response?.data?.message ?? "Failed to update client.");
            setError(msg);
        },
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        updateMutation.mutate(form);
    };

    const set =
        (field: string) =>
        (
            e: React.ChangeEvent<
                HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement
            >,
        ) => {
            setForm((prev) => ({ ...prev, [field]: e.target.value }));
        };

    if (loadingClient) {
        return (
            <div className="flex justify-center py-24">
                <Spinner className="h-8 w-8" />
            </div>
        );
    }

    const therapists: User[] =
        createData?.therapists ?? clientData?.therapists ?? [];
    const categories: string[] = createData?.categories ?? [];

    return (
        <div className="max-w-2xl mx-auto space-y-6">
            <div className="flex items-center gap-4">
                <Link
                    href={`/clients/${id}`}
                    className="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Client
                </Link>
                <h1 className="text-2xl font-bold text-gray-900">
                    Edit Client
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
                <div className="grid grid-cols-2 gap-4">
                    <Input
                        id="client_code"
                        label="Client Code *"
                        value={form.client_code ?? ""}
                        onChange={set("client_code")}
                        required
                    />
                    <Input
                        id="legal_name"
                        label="Legal Name"
                        value={form.legal_name ?? ""}
                        onChange={set("legal_name")}
                    />
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <Input
                        id="preferred_name"
                        label="Preferred Name"
                        value={form.preferred_name ?? ""}
                        onChange={set("preferred_name")}
                    />
                    <Input
                        id="email"
                        type="email"
                        label="Email"
                        value={form.email ?? ""}
                        onChange={set("email")}
                    />
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <Input
                        id="phone"
                        label="Phone"
                        value={form.phone ?? ""}
                        onChange={set("phone")}
                    />
                    <Input
                        id="client_contribution"
                        type="number"
                        label="Client Contribution ($)"
                        value={form.client_contribution?.toString() ?? ""}
                        onChange={set("client_contribution")}
                    />
                </div>

                <div>
                    <label
                        htmlFor="user_id"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Assigned Therapist
                    </label>
                    <select
                        id="user_id"
                        value={form.user_id ?? ""}
                        onChange={set("user_id")}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">No therapist</option>
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
                            htmlFor="category"
                            className="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Category
                        </label>
                        <select
                            id="category"
                            value={form.category ?? ""}
                            onChange={set("category")}
                            className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="">None</option>
                            {categories.map((c) => (
                                <option key={c} value={c}>
                                    {c}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label
                            htmlFor="status"
                            className="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Status
                        </label>
                        <select
                            id="status"
                            value={form.status?.toString() ?? "0"}
                            onChange={set("status")}
                            className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="0">Active</option>
                            <option value="1">Inactive</option>
                        </select>
                    </div>
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
                        value={form.notes ?? ""}
                        onChange={set("notes")}
                        rows={3}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <div className="flex justify-end gap-3 pt-2">
                    <Link href={`/clients/${id}`}>
                        <Button variant="secondary" type="button">
                            Cancel
                        </Button>
                    </Link>
                    <Button type="submit" loading={updateMutation.isPending}>
                        Save Changes
                    </Button>
                </div>
            </form>
        </div>
    );
}
