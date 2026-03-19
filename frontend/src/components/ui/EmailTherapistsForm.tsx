import React from "react";

interface EmailTherapistsFormProps {
    form: { subject: string; message: string };
    onChange: (form: { subject: string; message: string }) => void;
    onSubmit: (e: React.FormEvent) => void;
    loading?: boolean;
}

import Input from "@/components/ui/Input";
import Button from "@/components/ui/Button";

export default function EmailTherapistsForm({
    form,
    onChange,
    onSubmit,
    loading,
}: EmailTherapistsFormProps) {
    return (
        <form
            onSubmit={onSubmit}
            className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-5"
        >
            <Input
                id="subject"
                label="Subject *"
                value={form.subject}
                onChange={(e) => onChange({ ...form, subject: e.target.value })}
                required
            />

            <div>
                <label
                    htmlFor="message"
                    className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                >
                    Message *
                </label>
                <textarea
                    id="message"
                    value={form.message}
                    onChange={(e) =>
                        onChange({ ...form, message: e.target.value })
                    }
                    rows={8}
                    required
                    className="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Write your message to all therapists..."
                />
            </div>

            <div className="flex justify-end">
                <Button type="submit" loading={loading}>
                    Send to All Therapists
                </Button>
            </div>
        </form>
    );
}
