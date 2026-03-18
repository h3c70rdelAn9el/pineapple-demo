import Link from "next/link";

const colors: Record<string, string> = {
    indigo: "from-indigo-500 to-indigo-600",
    green: "from-emerald-500 to-emerald-600",
    red: "from-rose-500 to-rose-600",
    yellow: "from-amber-400 to-amber-500",
    purple: "from-violet-500 to-violet-600",
};

export default function StatCard({
    label,
    value,
    sub,
    color = "indigo",
    href,
}: {
    label: string;
    value: string | number;
    sub?: string;
    color?: string;
    href?: string;
}) {
    const card = (
        <div
            className={`relative flex flex-col justify-between h-32 rounded-xl bg-gradient-to-br ${colors[color] ?? colors.indigo} p-5 shadow-md text-white${href ? " hover:shadow-lg hover:scale-[1.02] transition-all duration-200" : ""}`}
        >
            <p className="text-sm font-medium text-white/80">{label}</p>
            <p className="text-4xl font-bold tracking-tight">{value}</p>
            {sub && <p className="text-xs text-white/60">{sub}</p>}
        </div>
    );

    if (href) {
        return <Link href={href}>{card}</Link>;
    }

    return card;
}
