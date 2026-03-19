"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { useQuery, useMutation } from "@tanstack/react-query";
import Link from "next/link";
import { use } from "react";
import api from "@/lib/api";
import * as TherapistActions from "@/actions/App/Http/Controllers/Api/TherapistController";
import Button from "@/components/ui/Button";
import Input from "@/components/ui/Input";
import Spinner from "@/components/ui/Spinner";
import { User } from "@/types";

export default function EditTherapistPage({
    params,
}: {
    params: Promise<{ id: string }>;
}) {
    const { id } = use(params);
    const router = useRouter();
    const [error, setError] = useState<string | null>(null);
    const [form, setForm] = useState<Partial<User>>({});

    const { data, isLoading } = useQuery<{ therapist: User }>({
        queryKey: ["therapist-edit", id],
        queryFn: () =>
            api.get(TherapistActions.edit.url(id)).then((r) => r.data),
    });

    useEffect(() => {
        if (data?.therapist) {
            setForm(data.therapist);
        }
    }, [data]);

    const updateMutation = useMutation({
        mutationFn: (payload: Partial<User>) =>
            api.put(TherapistActions.update.url(id), payload),
        onSuccess: () => router.push(`/therapists/${id}`),
        onError: (err: {
            response?: {
                data?: { message?: string; errors?: Record<string, string[]> };
            };
        }) => {
            const msg = err.response?.data?.errors
                ? Object.values(err.response.data.errors).flat().join(" ")
                : (err.response?.data?.message ??
                  "Failed to update therapist.");
            setError(msg);
        },
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        updateMutation.mutate(form);
    };

    const set =
        (field: keyof User) =>
        (
            e: React.ChangeEvent<
                HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement
            >,
        ) => {
            setForm((prev) => ({ ...prev, [field]: e.target.value }));
        };

    if (isLoading) {
        return (
            <div className="flex justify-center py-24">
                <Spinner className="h-8 w-8" />
            </div>
        );
    }

    return (
        <div className="max-w-2xl mx-auto space-y-6">
            <div className="flex items-center gap-4">
                <Link
                    href={`/therapists/${id}`}
                    className="text-sm text-gray-500 hover:text-gray-700"
                >
                    ← Therapist
                </Link>
                <h1 className="text-2xl font-bold text-gray-900">
                    Edit Therapist
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
                        id="name"
                        label="Full Name"
                        value={form.name ?? ""}
                        onChange={set("name")}
                    />
                    <Input
                        id="preferred_name"
                        label="Preferred Name"
                        value={form.preferred_name ?? ""}
                        onChange={set("preferred_name")}
                    />
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <Input
                        id="email"
                        type="email"
                        label="Email"
                        value={form.email ?? ""}
                        onChange={set("email")}
                    />
                    <Input
                        id="phone"
                        label="Phone"
                        value={form.phone ?? ""}
                        onChange={set("phone")}
                    />
                </div>

                <div className="grid grid-cols-3 gap-4">
                    <Input
                        id="city"
                        label="City"
                        value={form.city ?? ""}
                        onChange={set("city")}
                    />
                    <Input
                        id="state"
                        label="State"
                        value={form.state ?? ""}
                        onChange={set("state")}
                    />
                    <Input
                        id="zip"
                        label="ZIP"
                        value={form.zip ?? ""}
                        onChange={set("zip")}
                    />
                </div>

                <div>
                    <label
                        htmlFor="active_status"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Status
                    </label>
                    <select
                        id="active_status"
                        value={form.active_status?.toString() ?? "0"}
                        onChange={set("active_status")}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>
                    </select>
                </div>

                <div>
                    <label
                        htmlFor="bio"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Bio
                    </label>
                    <textarea
                        id="bio"
                        value={form.bio ?? ""}
                        onChange={set("bio")}
                        rows={4}
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <div className="flex justify-end gap-3 pt-2">
                    <Link href={`/therapists/${id}`}>
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
