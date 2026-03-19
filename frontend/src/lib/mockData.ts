/**
 * MOCK DATA — Fake data for frontend demo without a backend.
 * Remove this file and the mock interceptor when the real API is available.
 */

import type {
    User,
    Client,
    TherapySession,
    PaginatedResponse,
    DashboardData,
    ClientsData,
    TherapistsData,
} from "@/types";

// ─── Therapists (Users) ────────────────────────────────────────────

export const therapists: User[] = [
    {
        id: 1,
        name: "Daffy Duck",
        email: "daffy@example.com",
        preferred_name: "Daffy",
        admin: true,
        active_status: 1,
        address: "123 Pond Lane",
        city: "Burbank",
        state: "CA",
        zip: "91505",
        phone: "(818) 555-0101",
        bio: "Licensed clinical psychologist specializing in anxiety and mood disorders. Over 10 years of experience working with diverse populations.",
        gender: "Male",
        about: "Passionate about helping clients achieve breakthroughs.",
        background: "PhD Clinical Psychology, UCLA",
        created_at: "2024-01-15T08:00:00.000000Z",
        updated_at: "2025-11-20T14:30:00.000000Z",
    },
    {
        id: 2,
        name: "Bugs Bunny",
        email: "bugs@example.com",
        preferred_name: "Bugs",
        admin: false,
        active_status: 1,
        address: "456 Carrot Ave",
        city: "Glendale",
        state: "CA",
        zip: "91201",
        phone: "(818) 555-0202",
        bio: "Cognitive behavioral therapist with a focus on resilience and personal growth. Warm, empathetic approach.",
        gender: "Male",
        about: null,
        background: "MSW, USC",
        created_at: "2024-03-10T09:00:00.000000Z",
        updated_at: "2025-12-01T10:00:00.000000Z",
    },
    {
        id: 3,
        name: "Lola Bunny",
        email: "lola@example.com",
        preferred_name: "Lola",
        admin: false,
        active_status: 1,
        address: "789 Hoop St",
        city: "Pasadena",
        state: "CA",
        zip: "91101",
        phone: "(626) 555-0303",
        bio: "Specializes in trauma-informed care and EMDR therapy. Works with adolescents and adults.",
        gender: "Female",
        about: null,
        background: "PsyD, Pepperdine",
        created_at: "2024-05-22T11:00:00.000000Z",
        updated_at: "2025-10-15T09:00:00.000000Z",
    },
    {
        id: 4,
        name: "Tweety Bird",
        email: "tweety@example.com",
        preferred_name: null,
        admin: false,
        active_status: 0,
        address: null,
        city: "Los Angeles",
        state: "CA",
        zip: null,
        phone: "(213) 555-0404",
        bio: null,
        gender: null,
        about: null,
        background: null,
        created_at: "2024-07-01T08:00:00.000000Z",
        updated_at: "2025-08-01T08:00:00.000000Z",
    },
    {
        id: 5,
        name: "Porky Pig",
        email: "porky@example.com",
        preferred_name: "Porky",
        admin: false,
        active_status: 1,
        address: "321 Farmhouse Rd",
        city: "Arcadia",
        state: "CA",
        zip: "91006",
        phone: "(626) 555-0505",
        bio: "Family therapist with 8 years of experience. Focuses on communication skills and conflict resolution.",
        gender: "Male",
        about: null,
        background: "MFT, Loyola Marymount",
        created_at: "2024-02-14T10:00:00.000000Z",
        updated_at: "2025-12-10T12:00:00.000000Z",
    },
];

// ─── Clients ────────────────────────────────────────────────────────

export const clients: Client[] = [
    {
        id: 1,
        client_code: "CL-1001",
        legal_name: "Elmer Fudd",
        preferred_name: "Elmer",
        email: "elmer@example.com",
        phone: "(818) 555-1001",
        status: 0,
        waitlist: 0,
        special_sessions: 0,
        category: "Individual",
        user_id: 1,
        client_contribution: 25,
        notes: "Prefers morning sessions.",
        created_at: "2024-06-01T08:00:00.000000Z",
        updated_at: "2025-11-01T09:00:00.000000Z",
        user: therapists[0],
    },
    {
        id: 2,
        client_code: "CL-1002",
        legal_name: "Yosemite Sam",
        preferred_name: "Sam",
        email: "sam@example.com",
        phone: "(818) 555-1002",
        status: 0,
        waitlist: 0,
        special_sessions: 1,
        category: "Couples",
        user_id: 2,
        client_contribution: 40,
        notes: null,
        created_at: "2024-07-15T10:00:00.000000Z",
        updated_at: "2025-10-20T14:00:00.000000Z",
        user: therapists[1],
    },
    {
        id: 3,
        client_code: "CL-1003",
        legal_name: "Road Runner",
        preferred_name: null,
        email: "roadrunner@example.com",
        phone: "(626) 555-1003",
        status: 0,
        waitlist: 0,
        special_sessions: 0,
        category: "Individual",
        user_id: 1,
        client_contribution: 30,
        notes: "Very punctual.",
        created_at: "2024-08-01T09:00:00.000000Z",
        updated_at: "2025-12-05T11:00:00.000000Z",
        user: therapists[0],
    },
    {
        id: 4,
        client_code: "CL-1004",
        legal_name: "Wile E. Coyote",
        preferred_name: "Wile",
        email: "wile@example.com",
        phone: "(213) 555-1004",
        status: 1,
        waitlist: 0,
        special_sessions: 0,
        category: "Individual",
        user_id: 2,
        client_contribution: 20,
        notes: "On pause — will resume in spring.",
        created_at: "2024-04-10T08:00:00.000000Z",
        updated_at: "2025-09-15T10:00:00.000000Z",
        user: therapists[1],
    },
    {
        id: 5,
        client_code: "CL-1005",
        legal_name: "Sylvester Cat",
        preferred_name: "Sly",
        email: "sylvester@example.com",
        phone: "(818) 555-1005",
        status: 0,
        waitlist: 1,
        special_sessions: 0,
        category: "Group",
        user_id: 3,
        client_contribution: 15,
        notes: null,
        created_at: "2024-09-20T11:00:00.000000Z",
        updated_at: "2025-11-25T15:00:00.000000Z",
        user: therapists[2],
    },
    {
        id: 6,
        client_code: "CL-1006",
        legal_name: "Marvin Martian",
        preferred_name: "Marvin",
        email: "marvin@example.com",
        phone: "(626) 555-1006",
        status: 0,
        waitlist: 0,
        special_sessions: 1,
        category: "Individual",
        user_id: 3,
        client_contribution: 35,
        notes: "Interested in group transition.",
        created_at: "2024-10-05T13:00:00.000000Z",
        updated_at: "2025-12-12T16:00:00.000000Z",
        user: therapists[2],
    },
    {
        id: 7,
        client_code: "CL-1007",
        legal_name: "Pepé Le Pew",
        preferred_name: "Pepé",
        email: "pepe@example.com",
        phone: "(213) 555-1007",
        status: 0,
        waitlist: 0,
        special_sessions: 0,
        category: "Couples",
        user_id: 5,
        client_contribution: 50,
        notes: null,
        created_at: "2024-11-01T08:00:00.000000Z",
        updated_at: "2025-12-15T08:00:00.000000Z",
        user: therapists[4],
    },
    {
        id: 8,
        client_code: "CL-1008",
        legal_name: "Foghorn Leghorn",
        preferred_name: "Foghorn",
        email: "foghorn@example.com",
        phone: "(818) 555-1008",
        status: 1,
        waitlist: 0,
        special_sessions: 0,
        category: "Individual",
        user_id: 5,
        client_contribution: 20,
        notes: "Completed treatment plan.",
        created_at: "2024-03-20T10:00:00.000000Z",
        updated_at: "2025-07-01T09:00:00.000000Z",
        user: therapists[4],
    },
];

// ─── Therapy Sessions ───────────────────────────────────────────────

export const sessions: TherapySession[] = [
    {
        id: 1,
        client_id: 1,
        user_id: 1,
        attendance: "attended",
        session_cost: 150,
        special: 0,
        notes: "Good progress on coping strategies.",
        session_date: "2025-12-01",
        created_at: "2025-12-01T10:00:00Z",
        updated_at: "2025-12-01T11:00:00Z",
        client: clients[0],
        user: therapists[0],
    },
    {
        id: 2,
        client_id: 1,
        user_id: 1,
        attendance: "attended",
        session_cost: 150,
        special: 0,
        notes: null,
        session_date: "2025-12-08",
        created_at: "2025-12-08T10:00:00Z",
        updated_at: "2025-12-08T11:00:00Z",
        client: clients[0],
        user: therapists[0],
    },
    {
        id: 3,
        client_id: 1,
        user_id: 1,
        attendance: "no-show",
        session_cost: 150,
        special: 0,
        notes: "Client called to reschedule.",
        session_date: "2025-12-15",
        created_at: "2025-12-15T10:00:00Z",
        updated_at: "2025-12-15T11:00:00Z",
        client: clients[0],
        user: therapists[0],
    },
    {
        id: 4,
        client_id: 2,
        user_id: 2,
        attendance: "attended",
        session_cost: 175,
        special: 1,
        notes: "Couples intake session.",
        session_date: "2025-11-20",
        created_at: "2025-11-20T14:00:00Z",
        updated_at: "2025-11-20T15:00:00Z",
        client: clients[1],
        user: therapists[1],
    },
    {
        id: 5,
        client_id: 2,
        user_id: 2,
        attendance: "attended",
        session_cost: 175,
        special: 0,
        notes: null,
        session_date: "2025-12-04",
        created_at: "2025-12-04T14:00:00Z",
        updated_at: "2025-12-04T15:00:00Z",
        client: clients[1],
        user: therapists[1],
    },
    {
        id: 6,
        client_id: 3,
        user_id: 1,
        attendance: "attended",
        session_cost: 150,
        special: 0,
        notes: "Reviewed goals for next quarter.",
        session_date: "2025-12-03",
        created_at: "2025-12-03T09:00:00Z",
        updated_at: "2025-12-03T10:00:00Z",
        client: clients[2],
        user: therapists[0],
    },
    {
        id: 7,
        client_id: 3,
        user_id: 1,
        attendance: "missed",
        session_cost: 150,
        special: 0,
        notes: null,
        session_date: "2025-12-10",
        created_at: "2025-12-10T09:00:00Z",
        updated_at: "2025-12-10T10:00:00Z",
        client: clients[2],
        user: therapists[0],
    },
    {
        id: 8,
        client_id: 5,
        user_id: 3,
        attendance: "attended",
        session_cost: 125,
        special: 0,
        notes: "Exploring group therapy options.",
        session_date: "2025-12-05",
        created_at: "2025-12-05T11:00:00Z",
        updated_at: "2025-12-05T12:00:00Z",
        client: clients[4],
        user: therapists[2],
    },
    {
        id: 9,
        client_id: 6,
        user_id: 3,
        attendance: "attended",
        session_cost: 140,
        special: 1,
        notes: "Special session — crisis intervention.",
        session_date: "2025-12-07",
        created_at: "2025-12-07T16:00:00Z",
        updated_at: "2025-12-07T17:00:00Z",
        client: clients[5],
        user: therapists[2],
    },
    {
        id: 10,
        client_id: 6,
        user_id: 3,
        attendance: "no-show",
        session_cost: 140,
        special: 0,
        notes: null,
        session_date: "2025-12-14",
        created_at: "2025-12-14T16:00:00Z",
        updated_at: "2025-12-14T17:00:00Z",
        client: clients[5],
        user: therapists[2],
    },
    {
        id: 11,
        client_id: 7,
        user_id: 5,
        attendance: "attended",
        session_cost: 160,
        special: 0,
        notes: "First session, discussed treatment plan.",
        session_date: "2025-12-02",
        created_at: "2025-12-02T13:00:00Z",
        updated_at: "2025-12-02T14:00:00Z",
        client: clients[6],
        user: therapists[4],
    },
    {
        id: 12,
        client_id: 7,
        user_id: 5,
        attendance: "attended",
        session_cost: 160,
        special: 0,
        notes: null,
        session_date: "2025-12-09",
        created_at: "2025-12-09T13:00:00Z",
        updated_at: "2025-12-09T14:00:00Z",
        client: clients[6],
        user: therapists[4],
    },
];

// ─── Helpers ────────────────────────────────────────────────────────

function paginate<T>(items: T[], page = 1, perPage = 15): PaginatedResponse<T> {
    const total = items.length;
    const lastPage = Math.max(1, Math.ceil(total / perPage));
    const from = total > 0 ? (page - 1) * perPage + 1 : null;
    const to = total > 0 ? Math.min(page * perPage, total) : null;
    return {
        data: items.slice((page - 1) * perPage, page * perPage),
        current_page: page,
        last_page: lastPage,
        per_page: perPage,
        total,
        from,
        to,
    };
}

const activeTherapists = therapists.filter((t) => t.active_status === 1);
const inactiveTherapists = therapists.filter((t) => t.active_status === 0);
const completeTherapists = therapists.filter((t) => t.bio && t.phone && t.city);
const incompleteTherapists = therapists.filter(
    (t) => !t.bio || !t.phone || !t.city,
);
const unverifiedTherapists = therapists.filter((t) => !t.bio);

const activeClients = clients.filter((c) => c.status === 0);
const inactiveClients = clients.filter((c) => c.status === 1);
const waitlistClients = clients.filter((c) => c.waitlist === 1);
const specialClients = clients.filter((c) => c.special_sessions === 1);

const attendedSessions = sessions.filter((s) => s.attendance === "attended");
const missedSessions = sessions.filter(
    (s) => s.attendance === "missed" || s.attendance === "no-show",
);
const specialSessions = sessions.filter((s) => s.special === 1);

// ─── API Response Builders ──────────────────────────────────────────

export function getDashboardData(): DashboardData {
    return {
        user: therapists[0],
        isAdmin: true,
        allClients: paginate(clients),
        activeClients,
        inactiveClients,
        therapists: paginate(therapists),
        inactiveTherapists: paginate(inactiveTherapists),
        activeTherapists: paginate(activeTherapists),
        allTherapySessions: paginate(sessions),
        allMissedSessions: paginate(missedSessions),
        allSpecialSessions: paginate(specialSessions),
        recentActiveClients: activeClients.slice(0, 5),
        unreadMessagesCount: 3,
        incompleteTherapistsCount: incompleteTherapists.length,
        completeTherapistsCount: completeTherapists.length,
        unverifiedTherapistCount: unverifiedTherapists.length,
        totalSessionCost: sessions.reduce(
            (s, x) => s + (x.session_cost ?? 0),
            0,
        ),
        totalClientContribution: clients.reduce(
            (s, x) => s + (x.client_contribution ?? 0),
            0,
        ),
        totalClientCount: clients.length,
        clients: paginate(clients),
        therapySessions: sessions,
    };
}

export function getTherapistsData(): TherapistsData {
    return {
        therapists: paginate(therapists),
        activeTherapists: paginate(activeTherapists),
        inactiveTherapists: paginate(inactiveTherapists),
        completeTherapists: paginate(completeTherapists),
        incompleteTherapists: paginate(incompleteTherapists),
        unverifiedTherapists: paginate(unverifiedTherapists),
    };
}

export function getTherapist(id: number) {
    return { therapist: therapists.find((t) => t.id === id) ?? therapists[0] };
}

export function getClientsData(): ClientsData {
    return {
        clients: paginate(clients),
        allClients: paginate(clients),
        therapists,
        inactiveClients: paginate(inactiveClients),
        waitlistClients: paginate(waitlistClients),
        specialSessionsClients: paginate(specialClients),
        allInactiveClients: paginate(inactiveClients),
        allWaitlistClients: paginate(waitlistClients),
        allSpecialSessionClients: paginate(specialClients),
        therapySessions: sessions,
        attendedSessions: attendedSessions.length,
        missedSessions: missedSessions.length,
        allAttendedSessions: attendedSessions.length,
        allMissedSessions: missedSessions.length,
        sortBy: "legal_name",
        sortDirection: "asc",
    };
}

export function getClient(id: number) {
    const client = clients.find((c) => c.id === id) ?? clients[0];
    const clientSessions = sessions.filter((s) => s.client_id === client.id);
    return {
        client,
        therapySessions: clientSessions,
        attendedSessions: clientSessions.filter(
            (s) => s.attendance === "attended",
        ),
    };
}

export function getClientsCreateData() {
    return {
        therapists,
        categories: ["Individual", "Couples", "Group", "Family"],
    };
}

export function getSessionsData() {
    return {
        sessions: paginate(sessions),
        missedSessions: paginate(missedSessions),
        specialSessions: paginate(specialSessions),
        allTherapySessions: paginate(sessions),
        allMissedSessions: paginate(missedSessions),
        allSpecialSessions: paginate(specialSessions),
    };
}

export function getSession(id: number) {
    const session = sessions.find((s) => s.id === id) ?? sessions[0];
    return { session, therapySession: session };
}

export function getAdminStats() {
    const monthlyData = [
        { month: "Jan", sessions: 8, cost: 1200 },
        { month: "Feb", sessions: 10, cost: 1500 },
        { month: "Mar", sessions: 12, cost: 1800 },
        { month: "Apr", sessions: 9, cost: 1350 },
        { month: "May", sessions: 11, cost: 1650 },
        { month: "Jun", sessions: 14, cost: 2100 },
        { month: "Jul", sessions: 7, cost: 1050 },
        { month: "Aug", sessions: 13, cost: 1950 },
        { month: "Sep", sessions: 10, cost: 1500 },
        { month: "Oct", sessions: 12, cost: 1800 },
        { month: "Nov", sessions: 11, cost: 1650 },
        { month: "Dec", sessions: 12, cost: 1825 },
    ];
    return {
        stats: {
            totalClients: clients.length,
            activeClients: activeClients.length,
            inactiveClients: inactiveClients.length,
            waitlistClients: waitlistClients.length,
            totalTherapists: therapists.length,
            activeTherapists: activeTherapists.length,
            totalSessions: sessions.length,
            attendedSessions: attendedSessions.length,
            missedSessions: missedSessions.length,
            avgSessionsPerClient: +(sessions.length / clients.length).toFixed(
                1,
            ),
            totalSessionCost: sessions.reduce(
                (s, x) => s + (x.session_cost ?? 0),
                0,
            ),
            totalClientContribution: clients.reduce(
                (s, x) => s + (x.client_contribution ?? 0),
                0,
            ),
            monthlyData,
        },
        year: 2025,
        availableYears: [2024, 2025],
    };
}
