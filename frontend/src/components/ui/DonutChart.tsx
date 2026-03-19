"use client";

import {
    ResponsiveContainer,
    PieChart,
    Pie,
    Cell,
    Tooltip,
    Legend,
} from "recharts";

const CHART_COLORS = [
    "#4f46e5",
    "#22c55e",
    "#ef4444",
    "#f59e0b",
    "#8b5cf6",
    "#06b6d4",
];

interface DonutChartProps {
    data: { name: string; value: number }[];
    height?: number;
    colors?: string[];
}

export default function DonutChart({
    data,
    height = 200,
    colors,
}: DonutChartProps) {
    const palette = colors ?? CHART_COLORS;
    const filtered = data.filter((d) => d.value > 0);

    if (filtered.length === 0) {
        return (
            <div
                className="flex items-center justify-center text-sm text-gray-400"
                style={{ height }}
            >
                No data
            </div>
        );
    }

    return (
        <ResponsiveContainer width="100%" height={height}>
            <PieChart>
                <Pie
                    data={filtered}
                    cx="50%"
                    cy="50%"
                    innerRadius={55}
                    outerRadius={80}
                    paddingAngle={3}
                    dataKey="value"
                >
                    {filtered.map((_, i) => (
                        <Cell key={i} fill={palette[i % palette.length]} />
                    ))}
                </Pie>
                <Tooltip formatter={(v) => (v as number).toLocaleString()} />
                <Legend iconType="circle" iconSize={10} />
            </PieChart>
        </ResponsiveContainer>
    );
}
