"use client";

import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { useAuth } from "@/providers/AuthProvider";
import { SidebarProvider, useSidebar } from "@/providers/SidebarProvider";
import Sidebar from "@/components/layout/Sidebar";
import Spinner from "@/components/ui/Spinner";

function AppContent({ children }: { children: React.ReactNode }) {
    const { collapsed } = useSidebar();

    return (
        <div className="min-h-screen bg-gray-50 dark:bg-gray-950">
            <Sidebar />
            <main
                className={`min-h-screen transition-all duration-200 ${collapsed ? "lg:pl-[68px]" : "lg:pl-64"}`}
            >
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-16 lg:pt-8">
                    {children}
                </div>
            </main>
        </div>
    );
}

export default function AppLayout({ children }: { children: React.ReactNode }) {
    const { user, loading } = useAuth();
    const router = useRouter();

    useEffect(() => {
        if (!loading && !user) {
            router.push("/login");
        }
    }, [user, loading, router]);

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center">
                <Spinner className="h-8 w-8" />
            </div>
        );
    }

    if (!user) {
        return null;
    }

    return (
        <SidebarProvider>
            <AppContent>{children}</AppContent>
        </SidebarProvider>
    );
}
