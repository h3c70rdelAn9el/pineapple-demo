"use client";

import { useState } from "react";
import { useMutation } from "@tanstack/react-query";
import api from "@/lib/api";
import * as AdminEmailActions from "@/actions/App/Http/Controllers/Api/AdminEmailController";

import EmailTherapistsForm from "@/components/ui/EmailTherapistsForm";

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
            <h1 className="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Email Therapists
            </h1>
            <p className="text-sm text-gray-500 dark:text-gray-400">
                Send a broadcast email to all active therapists.
            </p>

            {success && (
                <div className="rounded-md bg-green-50 dark:bg-green-900/30 p-3 text-green-700 dark:text-green-300 text-sm border border-green-200 dark:border-green-700">
                    Email sent successfully to all therapists!
                </div>
            )}

            {error && (
                <div className="rounded-md bg-red-50 dark:bg-red-900/30 p-3 text-red-700 dark:text-red-300 text-sm border border-red-200 dark:border-red-700">
                    {error}
                </div>
            )}

            <EmailTherapistsForm
                form={form}
                onChange={setForm}
                onSubmit={handleSubmit}
                loading={sendMutation.isPending}
            />
        </div>
    );
}
