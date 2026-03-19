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
    api.interceptors.request.use((config) => {
        const url = config.url ?? "";
        const method = (config.method ?? "get").toLowerCase();

        // eslint-disable-next-line @typescript-eslint/no-explicit-any
        let mockResponse: any = null;

        // Skip CSRF cookie requests
        if (url.includes("/sanctum/csrf-cookie")) {
            mockResponse = {};
        }
        // Auth
        else if (url.includes("/api/user")) {
            mockResponse = therapists[0];
        }
        // Dashboard
        else if (url.includes("/api/dashboard")) {
            mockResponse = getDashboardData();
        }
        // Admin stats
        else if (url.includes("/api/admin/stats")) {
            mockResponse = getAdminStats();
        }
        // Admin email (POST — just return success)
        else if (
            url.includes("/api/admin/email-therapists") &&
            method === "post"
        ) {
            mockResponse = { message: "Emails sent successfully." };
        }
        // Sessions CRUD
        else if (/\/api\/sessions\/(\d+)/.test(url)) {
            const id = Number(url.match(/\/api\/sessions\/(\d+)/)?.[1]);
            if (method === "delete") {
                mockResponse = { message: "Session deleted." };
            } else if (method === "patch" || method === "put") {
                mockResponse = getSession(id);
            } else {
                mockResponse = getSession(id);
            }
        } else if (url.includes("/api/sessions") && method === "post") {
            mockResponse = {
                session: {
                    id: 99,
                    ...JSON.parse(config.data ?? "{}"),
                    created_at: new Date().toISOString(),
                    updated_at: new Date().toISOString(),
                },
            };
        } else if (url.includes("/api/sessions")) {
            mockResponse = getSessionsData();
        }
        // Clients create (GET for form options)
        else if (url.includes("/api/clients/create")) {
            mockResponse = getClientsCreateData();
        }
        // Clients CRUD
        else if (/\/api\/clients\/(\d+)/.test(url)) {
            const id = Number(url.match(/\/api\/clients\/(\d+)/)?.[1]);
            if (method === "delete") {
                mockResponse = { message: "Client deleted." };
            } else if (method === "put") {
                mockResponse = getClient(id);
            } else {
                mockResponse = getClient(id);
            }
        } else if (url.includes("/api/clients") && method === "post") {
            mockResponse = {
                client: {
                    id: 99,
                    ...JSON.parse(config.data ?? "{}"),
                    created_at: new Date().toISOString(),
                    updated_at: new Date().toISOString(),
                },
            };
        } else if (url.includes("/api/clients")) {
            mockResponse = getClientsData();
        }
        // Therapists CRUD
        else if (/\/api\/therapists\/(\d+)\/send-invoice/.test(url)) {
            mockResponse = { message: "Invoice sent." };
        } else if (/\/api\/therapists\/(\d+)\/edit/.test(url)) {
            const id = Number(url.match(/\/api\/therapists\/(\d+)/)?.[1]);
            mockResponse = getTherapist(id);
        } else if (/\/api\/therapists\/(\d+)/.test(url)) {
            const id = Number(url.match(/\/api\/therapists\/(\d+)/)?.[1]);
            if (method === "delete") {
                mockResponse = { message: "Therapist deleted." };
            } else if (method === "put") {
                mockResponse = getTherapist(id);
            } else {
                mockResponse = getTherapist(id);
            }
        } else if (url.includes("/api/therapists")) {
            mockResponse = getTherapistsData();
        }
        // Login/register/logout (no-op)
        else if (url.includes("/api/login") || url.includes("/api/register")) {
            mockResponse = { user: therapists[0] };
        } else if (url.includes("/api/logout")) {
            mockResponse = { message: "Logged out." };
        }
        // Profile
        else if (url.includes("/api/profile")) {
            mockResponse = therapists[0];
        }

        if (mockResponse !== null) {
            const error = new axios.Cancel("mock");
            // Attach mock data to the cancel so we can intercept it
            (error as any).__mockData = mockResponse;
            throw error;
        }

        return config;
    });

    api.interceptors.response.use(
        (response) => response,
        (error) => {
            if (
                axios.isCancel(error) &&
                (error as any).__mockData !== undefined
            ) {
                return Promise.resolve({
                    data: (error as any).__mockData,
                    status: 200,
                    statusText: "OK (mock)",
                    headers: {},
                    config: {} as any,
                });
            }
            return Promise.reject(error);
        },
    );
}

export async function getCsrfCookie(): Promise<void> {
    if (USE_MOCKS) return;
    await api.get("/sanctum/csrf-cookie");
}

export default api;
