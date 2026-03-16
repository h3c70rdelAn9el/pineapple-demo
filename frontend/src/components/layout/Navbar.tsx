"use client";

import { useState } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { useAuth } from "@/providers/AuthProvider";
import Spinner from "@/components/ui/Spinner";

const navLinks = [
    { href: "/dashboard", label: "Dashboard", adminOnly: false },
    { href: "/clients", label: "Clients", adminOnly: false },
    { href: "/sessions", label: "Sessions", adminOnly: false },
    { href: "/therapists", label: "Therapists", adminOnly: true },
    { href: "/admin/stats", label: "Stats", adminOnly: true },
    {
        href: "/admin/email-therapists",
        label: "Email Therapists",
        adminOnly: true,
    },
];

export default function Navbar() {
    const { user, logout } = useAuth();
    const pathname = usePathname();
    const [loggingOut, setLoggingOut] = useState(false);
    const [mobileOpen, setMobileOpen] = useState(false);

    const isAdmin = Boolean(user?.admin);

    const handleLogout = async () => {
        setLoggingOut(true);
        try {
            await logout();
            window.location.href = "/login";
        } finally {
            setLoggingOut(false);
        }
    };

    const links = navLinks.filter((l) => !l.adminOnly || isAdmin);

    return (
        <nav className="bg-white border-b border-gray-200">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    <div className="flex">
                        <Link
                            href="/dashboard"
                            className="flex items-center px-2 text-indigo-700 font-bold text-lg"
                        >
                            🍍 Therapy
                        </Link>
                        <div className="hidden sm:ml-6 sm:flex sm:space-x-4 items-center">
                            {links.map((link) => (
                                <Link
                                    key={link.href}
                                    href={link.href}
                                    className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                                        pathname.startsWith(link.href)
                                            ? "bg-indigo-50 text-indigo-700"
                                            : "text-gray-600 hover:text-gray-900 hover:bg-gray-50"
                                    }`}
                                >
                                    {link.label}
                                </Link>
                            ))}
                        </div>
                    </div>

                    <div className="hidden sm:flex items-center gap-4">
                        <span className="text-sm text-gray-600">
                            {user?.preferred_name ?? user?.name}
                        </span>
                        <button
                            onClick={handleLogout}
                            disabled={loggingOut}
                            className="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-900 disabled:opacity-50"
                        >
                            {loggingOut ? (
                                <Spinner className="h-4 w-4" />
                            ) : null}
                            Sign out
                        </button>
                    </div>

                    {/* Mobile hamburger */}
                    <div className="sm:hidden flex items-center">
                        <button
                            onClick={() => setMobileOpen(!mobileOpen)}
                            className="p-2 text-gray-500 hover:text-gray-700"
                            aria-label="Toggle menu"
                        >
                            <svg
                                className="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                {mobileOpen ? (
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                ) : (
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                )}
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {mobileOpen && (
                <div className="sm:hidden border-t border-gray-200 pb-3">
                    <div className="pt-2 pb-1 space-y-1 px-4">
                        {links.map((link) => (
                            <Link
                                key={link.href}
                                href={link.href}
                                onClick={() => setMobileOpen(false)}
                                className={`block px-3 py-2 rounded-md text-sm font-medium ${
                                    pathname.startsWith(link.href)
                                        ? "bg-indigo-50 text-indigo-700"
                                        : "text-gray-600 hover:text-gray-900 hover:bg-gray-50"
                                }`}
                            >
                                {link.label}
                            </Link>
                        ))}
                    </div>
                    <div className="pt-3 px-7 border-t border-gray-200">
                        <p className="text-sm text-gray-600 mb-2">
                            {user?.preferred_name ?? user?.name}
                        </p>
                        <button
                            onClick={handleLogout}
                            disabled={loggingOut}
                            className="text-sm text-red-600 hover:text-red-800 disabled:opacity-50"
                        >
                            Sign out
                        </button>
                    </div>
                </div>
            )}
        </nav>
    );
}
