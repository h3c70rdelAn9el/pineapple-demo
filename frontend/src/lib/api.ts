import axios from "axios";
import {
    getDashboardData,
    getTherapistsData,
    getTherapist,
    getClientsData,
    getClient,
    getClientsCreateData,
    getSessionsData,
    getSession,
    getAdminStats,
    therapists,
} from "./mockData";

// Set to true to use mock data instead of real API
const USE_MOCKS = true;

const api = axios.create({
    baseURL: "",
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

// ─── Mock Interceptor ───────────────────────────────────────────────
if (USE_MOCKS) {
    // Override the adapter so requests never hit the network.
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    function getMockResponse(url: string, method: string, data?: string): any {
        // CSRF
        if (url.includes("/sanctum/csrf-cookie")) return {};
        // Auth
        if (url.includes("/api/user")) return therapists[0];
        // Dashboard
        if (url.includes("/api/dashboard")) return getDashboardData();
        // Admin stats
        if (url.includes("/api/admin/stats")) return getAdminStats();
        // Admin email
        if (url.includes("/api/admin/email-therapists") && method === "post")
            return { message: "Emails sent successfully." };
        // Sessions CRUD
        if (/\/api\/sessions\/(\d+)/.test(url)) {
            const id = Number(url.match(/\/api\/sessions\/(\d+)/)?.[1]);
            if (method === "delete") return { message: "Session deleted." };
            return getSession(id);
        }
        if (url.includes("/api/sessions") && method === "post")
            return {
                session: {
                    id: 99,
                    ...JSON.parse(data ?? "{}"),
                    created_at: new Date().toISOString(),
                    updated_at: new Date().toISOString(),
                },
            };
        if (url.includes("/api/sessions")) return getSessionsData();
        // Clients create options
        if (url.includes("/api/clients/create")) return getClientsCreateData();
        // Clients CRUD
        if (/\/api\/clients\/(\d+)/.test(url)) {
            const id = Number(url.match(/\/api\/clients\/(\d+)/)?.[1]);
            if (method === "delete") return { message: "Client deleted." };
            return getClient(id);
        }
        if (url.includes("/api/clients") && method === "post")
            return {
                client: {
                    id: 99,
                    ...JSON.parse(data ?? "{}"),
                    created_at: new Date().toISOString(),
                    updated_at: new Date().toISOString(),
                },
            };
        if (url.includes("/api/clients")) return getClientsData();
        // Therapists CRUD
        if (/\/api\/therapists\/(\d+)\/send-invoice/.test(url))
            return { message: "Invoice sent." };
        if (/\/api\/therapists\/(\d+)\/edit/.test(url)) {
            const id = Number(url.match(/\/api\/therapists\/(\d+)/)?.[1]);
            return getTherapist(id);
        }
        if (/\/api\/therapists\/(\d+)/.test(url)) {
            const id = Number(url.match(/\/api\/therapists\/(\d+)/)?.[1]);
            if (method === "delete") return { message: "Therapist deleted." };
            return getTherapist(id);
        }
        if (url.includes("/api/therapists")) return getTherapistsData();
        // Login/register/logout
        if (url.includes("/api/login") || url.includes("/api/register"))
            return { user: therapists[0] };
        if (url.includes("/api/logout")) return { message: "Logged out." };
        // Profile
        if (url.includes("/api/profile")) return therapists[0];
        return {};
    }

    api.defaults.adapter = (config: any) => {
        const url = typeof config.url === "string" ? config.url : "";
        const method = (config.method ?? "get").toLowerCase();
        const body = typeof config.data === "string" ? config.data : undefined;
        const mockData = getMockResponse(url, method, body);
        return Promise.resolve({
            data: mockData,
            status: 200,
            statusText: "OK (mock)",
            headers: {},
            config,
        });
    };
}

export async function getCsrfCookie(): Promise<void> {
    if (USE_MOCKS) return;
    await api.get("/sanctum/csrf-cookie");
}

export default api;
