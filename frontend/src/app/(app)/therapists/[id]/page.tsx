"use client";

import { useQuery, useMutation } from "@tanstack/react-query";
import Link from "next/link";
import { use, useState } from "react";
import api from "@/lib/api";
import * as TherapistActions from "@/actions/App/Http/Controllers/Api/TherapistController";
import { User } from "@/types";
import Spinner from "@/components/ui/Spinner";
import Badge from "@/components/ui/Badge";
import Button from "@/components/ui/Button";
import Modal from "@/components/ui/Modal";

export default function TherapistShowPage({
    params,
}: {
    params: Promise<{ id: string }>;
}) {
    const { id } = use(params);
    const [invoiceModal, setInvoiceModal] = useState(false);
    const [invoiceSuccess, setInvoiceSuccess] = useState(false);

    const { data, isLoading, isError } = useQuery<{ therapist: User }>({
        queryKey: ["therapist", id],
        queryFn: () =>
            api.get(TherapistActions.show.url(id)).then((r) => r.data),
    });

    const invoiceMutation = useMutation({
        mutationFn: () =>
            api.post(TherapistActions.sendInvoice.url(id), {
                invoice_date: new Date().toISOString().split("T")[0],
            }),
        onSuccess: () => {
            setInvoiceModal(false);
            setInvoiceSuccess(true);
            setTimeout(() => setInvoiceSuccess(false), 4000);
        },
    });

    if (isLoading) {
        return (
            <div className="flex justify-center py-24">
                <Spinner className="h-8 w-8" />
            </div>
        );
    }

    if (isError || !data) {
        return (
            <div className="rounded-md bg-red-50 p-4 text-red-700 text-sm">
                Failed to load therapist.
            </div>
        );
    }

    const { therapist } = data;

    return (
        <div className="max-w-2xl mx-auto space-y-6">
            <div className="flex items-center justify-between">
                <div className="flex items-center gap-4">
                    <Link
                        href="/therapists"
                        className="text-sm text-gray-500 hover:text-gray-700"
                    >
                        ← Therapists
                    </Link>
                    <h1 className="text-2xl font-bold text-gray-900">
                        {therapist.preferred_name ?? therapist.name}
                    </h1>
                </div>
                <div className="flex gap-2">
                    <Button
                        size="sm"
                        variant="secondary"
                        onClick={() => setInvoiceModal(true)}
                    >
                        Send Invoice
                    </Button>
                    <Link href={`/therapists/${id}/edit`}>
                        <Button variant="secondary" size="sm">
                            Edit
                        </Button>
                    </Link>
                </div>
            </div>

            {invoiceSuccess && (
                <div className="rounded-md bg-green-50 p-3 text-green-700 text-sm border border-green-200">
                    Invoice sent successfully!
                </div>
            )}

            <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <div className="flex items-start justify-between mb-4">
                    <div />
                    <Badge
                        variant={
                            therapist.active_status === 0 ? "green" : "red"
                        }
                    >
                        {therapist.active_status === 0 ? "Active" : "Inactive"}
                    </Badge>
                </div>

                <dl className="grid grid-cols-2 gap-4">
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Name
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {therapist.preferred_name ?? therapist.name}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Legal Name
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {therapist.name}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Email
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {therapist.email}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Phone
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {therapist.phone ?? "—"}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            City / State
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {[therapist.city, therapist.state]
                                .filter(Boolean)
                                .join(", ") || "—"}
                        </dd>
                    </div>
                    <div>
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400">
                            Gender
                        </dt>
                        <dd className="text-sm text-gray-900 dark:text-gray-100 mt-0.5">
                            {therapist.gender ?? "—"}
                        </dd>
                    </div>
                </dl>

                {therapist.bio && (
                    <div className="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <dt className="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                            Bio
                        </dt>
                        <p className="text-sm text-gray-700 dark:text-gray-200">
                            {therapist.bio}
                        </p>
                    </div>
                )}
            </div>

            <Modal
                isOpen={invoiceModal}
                onClose={() => setInvoiceModal(false)}
                title="Send Invoice"
                footer={
                    <>
                        <Button
                            variant="secondary"
                            onClick={() => setInvoiceModal(false)}
                        >
                            Cancel
                        </Button>
                        <Button
                            loading={invoiceMutation.isPending}
                            onClick={() => invoiceMutation.mutate()}
                        >
                            Send Last Month Invoice
                        </Button>
                    </>
                }
            >
                <p className="text-sm text-gray-600">
                    Send last month&apos;s invoice to{" "}
                    <strong>
                        {therapist.preferred_name ?? therapist.name}
                    </strong>
                    ?
                </p>
            </Modal>
        </div>
    );
}
