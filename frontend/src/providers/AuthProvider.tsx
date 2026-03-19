"use client";

import {
    createContext,
    useContext,
    useEffect,
    useState,
    useCallback,
} from "react";
import api, { getCsrfCookie } from "@/lib/api";
import * as AuthActions from "@/actions/App/Http/Controllers/Api/AuthController";
import { User } from "@/types";

interface AuthContextType {
    user: User | null;
    loading: boolean;
    login: (
        email: string,
        password: string,
        remember?: boolean,
    ) => Promise<void>;
    register: (
        name: string,
        email: string,
        password: string,
        passwordConfirmation: string,
    ) => Promise<void>;
    logout: () => Promise<void>;
    refresh: () => Promise<void>;
}

const AuthContext = createContext<AuthContextType | null>(null);

export function AuthProvider({ children }: { children: React.ReactNode }) {
    const [user, setUser] = useState<User | null>(null);
    const [loading, setLoading] = useState(true);

    const refresh = useCallback(async () => {
        try {
            const res = await api.get(AuthActions.user.url());
            setUser(res.data);
        } catch {
            setUser(null);
        }
    }, []);

    useEffect(() => {
        refresh().finally(() => setLoading(false));
    }, [refresh]);

    const login = async (
        email: string,
        password: string,
        remember = false,
    ): Promise<void> => {
        await getCsrfCookie();
        const res = await api.post(AuthActions.login.url(), { email, password, remember });
        setUser(res.data.user);
    };

    const register = async (
        name: string,
        email: string,
        password: string,
        passwordConfirmation: string,
    ): Promise<void> => {
        await getCsrfCookie();
        const res = await api.post(AuthActions.register.url(), {
            name,
            email,
            password,
            password_confirmation: passwordConfirmation,
        });
        setUser(res.data.user);
    };

    const logout = async (): Promise<void> => {
        await api.post(AuthActions.logout.url());
        setUser(null);
    };

    return (
        <AuthContext.Provider
            value={{ user, loading, login, register, logout, refresh }}
        >
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth(): AuthContextType {
    const ctx = useContext(AuthContext);
    if (!ctx) {
        throw new Error("useAuth must be used inside AuthProvider");
    }
    return ctx;
}
