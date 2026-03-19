export interface User {
    id: number;
    name: string;
    email: string;
    preferred_name: string | null;
    admin: boolean | number;
    active_status: number;
    address?: string | null;
    address2?: string | null;
    city?: string | null;
    state?: string | null;
    zip?: string | null;
    phone?: string | null;
    bio?: string | null;
    gender?: string | null;
    about?: string | null;
    background?: string | null;
    created_at: string;
    updated_at: string;
}

export interface Client {
    id: number;
    client_code: string;
    legal_name: string;
    preferred_name: string | null;
    email: string | null;
    phone: string | null;
    status: number;
    waitlist: number;
    special_sessions: number;
    category: string | null;
    user_id: number | null;
    client_contribution: number | null;
    notes: string | null;
    created_at: string;
    updated_at: string;
    therapy_sessions?: TherapySession[];
    user?: User;
}

export interface TherapySession {
    id: number;
    client_id: number;
    user_id: number;
    attendance: "attended" | "no-show" | "missed" | null;
    session_cost: number | null;
    special: number;
    notes: string | null;
    session_date: string | null;
    created_at: string;
    updated_at: string;
    client?: Client;
    user?: User;
}

export interface PaginatedResponse<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
}

export interface DashboardData {
    user: User;
    isAdmin: boolean;
    allClients?: PaginatedResponse<Client>;
    activeClients?: Client[];
    inactiveClients?: Client[];
    therapists?: PaginatedResponse<User>;
    inactiveTherapists?: PaginatedResponse<User>;
    activeTherapists?: PaginatedResponse<User>;
    allTherapySessions?: PaginatedResponse<TherapySession>;
    allMissedSessions?: PaginatedResponse<TherapySession>;
    allSpecialSessions?: PaginatedResponse<TherapySession>;
    recentActiveClients?: Client[];
    unreadMessagesCount?: number;
    incompleteTherapistsCount?: number;
    completeTherapistsCount?: number;
    unverifiedTherapistCount?: number;
    totalSessionCost?: number;
    totalClientContribution?: number;
    totalClientCount?: number;
    clients?: PaginatedResponse<Client>;
    therapySessions?: TherapySession[];
}

export interface ClientsData {
    clients: PaginatedResponse<Client>;
    allClients: PaginatedResponse<Client>;
    therapists: User[];
    inactiveClients: PaginatedResponse<Client>;
    waitlistClients: PaginatedResponse<Client>;
    specialSessionsClients: PaginatedResponse<Client>;
    allInactiveClients: PaginatedResponse<Client>;
    allWaitlistClients: PaginatedResponse<Client>;
    allSpecialSessionClients: PaginatedResponse<Client>;
    therapySessions: TherapySession[];
    attendedSessions: number;
    missedSessions: number;
    allAttendedSessions?: number;
    allMissedSessions?: number;
    clientsByCategory?: Record<string, PaginatedResponse<Client>>;
    sortBy: string;
    sortDirection: "asc" | "desc";
}

export interface TherapistsData {
    therapists: PaginatedResponse<User>;
    activeTherapists: PaginatedResponse<User>;
    inactiveTherapists: PaginatedResponse<User>;
    completeTherapists: PaginatedResponse<User>;
    incompleteTherapists: PaginatedResponse<User>;
    unverifiedTherapists: PaginatedResponse<User>;
}
