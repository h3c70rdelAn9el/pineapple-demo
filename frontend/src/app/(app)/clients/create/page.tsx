"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import { useQuery, useMutation } from "@tanstack/react-query";
import Link from "next/link";
import api from "@/lib/api";
import Button from "@/components/ui/Button";
import Input from "@/components/ui/Input";
import Spinner from "@/components/ui/Spinner";
import { User } from "@/types";

interface CreateFormData {
    client_code: string;
    legal_name: string;
    preferred_name: string;
    email: string;
    phone: string;
    user_id: string;
    client_contribution: string;
    waitlist: boolean;
    special_sessions: boolean;
    category: string;
    max_sessions: string;
    additional_notes: string;
}

export default function CreateClientPage() {
    const router = useRouter();
    const [error, setError] = useState<string | null>(null);
    const [form, setForm] = useState<CreateFormData>({
        client_code: "",
        legal_name: "",
        preferred_name: "",
        email: "",
        phone: "",
        user_id: "",
        client_contribution: "",
        waitlist: false,
        special_sessions: false,
        category: "",
        max_sessions: "",
        additional_notes: "",
    });

    const { data: createData, isLoading: loadingForm } = useQuery({
        queryKey: ["clients-create"],
        queryFn: () => api.get("/api/clients/create").then((r) => r.data),
    });

    const createMutation = useMutation({
        mutationFn: (data: CreateFormData) => api.post("/api/clients", data),
        onSuccess: () => router.push("/clients"),
        onError: (err: {
            response?: {
                data?: { message?: string; errors?: Record<string, string[]> };
            };
        }) => {
            const msg = err.response?.data?.errors
                ? Object.values(err.response.data.errors).flat().join(" ")
                : (err.response?.data?.message ?? "Failed to create client.");
            setError(msg);
        },
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        createMutation.mutate(form);
    };

    const set =
        (field: keyof CreateFormData) =>
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

    const therapists: User[] = createData?.therapists ?? [];
    const categories: string[] = createData?.categories ?? [];

    return (
        <div className="max-w-2xl mx-auto space-y-6">
            <div className="flex items-center gap-4">
                <Link
                    href="/clients"
                    className="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Clients
                </Link>
                <h1 className="text-2xl font-bold text-gray-900">New Client</h1>
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
                        value={form.client_code}
                        onChange={set("client_code")}
                        required
                    />
                    <Input
                        id="legal_name"
                        label="Legal Name"
                        value={form.legal_name}
                        onChange={set("legal_name")}
                    />
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <Input
                        id="preferred_name"
                        label="Preferred Name"
                        value={form.preferred_name}
                        onChange={set("preferred_name")}
                    />
                    <Input
                        id="email"
                        type="email"
                        label="Email"
                        value={form.email}
                        onChange={set("email")}
                    />
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <Input
                        id="phone"
                        label="Phone"
                        value={form.phone}
                        onChange={set("phone")}
                    />
                    <Input
                        id="client_contribution"
                        type="number"
                        label="Client Contribution ($)"
                        value={form.client_contribution}
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
                        value={form.user_id}
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
                            value={form.category}
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
                    <Input
                        id="max_sessions"
                        type="number"
                        label="Max Sessions"
                        value={form.max_sessions}
                        onChange={set("max_sessions")}
                    />
                </div>

                <div className="flex gap-6">
                    <label className="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input
                            type="checkbox"
                            checked={form.waitlist}
                            onChange={set("waitlist")}
                            className="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        Add to waitlist
                    </label>
                    <label className="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input
                            type="checkbox"
                            checked={form.special_sessions}
                            onChange={set("special_sessions")}
                            className="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        Special sessions
                    </label>
                </div>

                <div>
                    <label
                        htmlFor="additional_notes"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Notes
                    </label>
                    <textarea
                        id="additional_notes"
                        value={form.additional_notes}
                        onChange={set("additional_notes")}
                        rows={3}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <div className="flex justify-end gap-3 pt-2">
                    <Link href="/clients">
                        <Button variant="secondary" type="button">
                            Cancel
                        </Button>
                    </Link>
                    <Button type="submit" loading={createMutation.isPending}>
                        Create Client
                    </Button>
                </div>
            </form>
        </div>
    );
}
