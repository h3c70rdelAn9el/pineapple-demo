"use client";

import { useState } from "react";
import { useMutation } from "@tanstack/react-query";
import api from "@/lib/api";
import * as AdminEmailActions from "@/actions/App/Http/Controllers/Api/AdminEmailController";
import Button from "@/components/ui/Button";
import Input from "@/components/ui/Input";

export default function EmailTherapistsPage() {
    const [form, setForm] = useState({
        subject: "",
        message: "",
    });
    const [success, setSuccess] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const sendMutation = useMutation({
        mutationFn: (data: typeof form) =>
            api.post(AdminEmailActions.send.url(), data),
        onSuccess: () => {
            setSuccess(true);
            setForm({ subject: "", message: "" });
            setTimeout(() => setSuccess(false), 5000);
        },
        onError: (err: { response?: { data?: { message?: string } } }) => {
            setError(err.response?.data?.message ?? "Failed to send email.");
        },
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setError(null);
        sendMutation.mutate(form);
    };

    return (
        <div className="max-w-2xl mx-auto space-y-6">
            <h1 className="text-2xl font-bold text-gray-900">
                Email Therapists
            </h1>
            <p className="text-sm text-gray-500">
                Send a broadcast email to all active therapists.
            </p>

            {success && (
                <div className="rounded-md bg-green-50 p-3 text-green-700 text-sm border border-green-200">
                    Email sent successfully to all therapists!
                </div>
            )}

            {error && (
                <div className="rounded-md bg-red-50 p-3 text-red-700 text-sm border border-red-200">
                    {error}
                </div>
            )}

            <form
                onSubmit={handleSubmit}
                className="bg-white rounded-lg border border-gray-200 shadow-sm p-6 space-y-5"
            >
                <Input
                    id="subject"
                    label="Subject *"
                    value={form.subject}
                    onChange={(e) =>
                        setForm((p) => ({ ...p, subject: e.target.value }))
                    }
                    required
                />

                <div>
                    <label
                        htmlFor="message"
                        className="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Message *
                    </label>
                    <textarea
                        id="message"
                        value={form.message}
                        onChange={(e) =>
                            setForm((p) => ({ ...p, message: e.target.value }))
                        }
                        rows={8}
                        required
                        className="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Write your message to all therapists..."
                    />
                </div>

                <div className="flex justify-end">
                    <Button type="submit" loading={sendMutation.isPending}>
                        Send to All Therapists
                    </Button>
                </div>
            </form>
        </div>
    );
}
