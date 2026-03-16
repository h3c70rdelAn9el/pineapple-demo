"use client";

import { useState, FormEvent } from "react";
import { useRouter } from "next/navigation";
import Link from "next/link";
import { useAuth } from "@/providers/AuthProvider";
import Button from "@/components/ui/Button";
import Input from "@/components/ui/Input";

export default function RegisterPage() {
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);
    const { register } = useAuth();
    const router = useRouter();

    const handleSubmit = async (e: FormEvent) => {
        e.preventDefault();
        setError(null);

        if (password !== passwordConfirmation) {
            setError("Passwords do not match.");
            return;
        }

        setLoading(true);
        try {
            await register(name, email, password, passwordConfirmation);
            router.push("/dashboard");
        } catch (err: unknown) {
            const data = (
                err as {
                    response?: {
                        data?: {
                            errors?: Record<string, string[]>;
                            message?: string;
                        };
                    };
                }
            )?.response?.data;
            if (data?.errors) {
                const firstError = Object.values(data.errors)[0]?.[0];
                setError(firstError ?? "Registration failed.");
            } else {
                setError(data?.message ?? "Registration failed.");
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="w-full max-w-sm">
            <div className="text-center mb-8">
                <h1 className="text-3xl font-bold text-indigo-700">🍍</h1>
                <h2 className="mt-2 text-2xl font-bold text-gray-900">
                    Create an account
                </h2>
            </div>

            <form
                onSubmit={handleSubmit}
                className="bg-white py-8 px-6 shadow-sm rounded-lg border border-gray-200 space-y-5"
            >
                {error && (
                    <div className="rounded-md bg-red-50 p-3 text-sm text-red-700 border border-red-200">
                        {error}
                    </div>
                )}

                <Input
                    id="name"
                    type="text"
                    label="Full name"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    autoComplete="name"
                    required
                />

                <Input
                    id="email"
                    type="email"
                    label="Email address"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    autoComplete="email"
                    required
                />

                <Input
                    id="password"
                    type="password"
                    label="Password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    autoComplete="new-password"
                    required
                />

                <Input
                    id="password_confirmation"
                    type="password"
                    label="Confirm password"
                    value={passwordConfirmation}
                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                    autoComplete="new-password"
                    required
                />

                <Button
                    type="submit"
                    loading={loading}
                    className="w-full justify-center"
                >
                    Create account
                </Button>
            </form>

            <p className="mt-4 text-center text-sm text-gray-600">
                Already have an account?{" "}
                <Link
                    href="/login"
                    className="font-medium text-indigo-600 hover:text-indigo-500"
                >
                    Sign in
                </Link>
            </p>
        </div>
    );
}
