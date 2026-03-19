import { ReactNode } from "react";

interface Column {
    label: ReactNode;
    className?: string;
    onClick?: () => void;
}

interface DataTableProps {
    columns: Column[];
    colSpan: number;
    isEmpty: boolean;
    emptyMessage?: string;
    children: ReactNode;
}

export default function DataTable({
    columns,
    colSpan,
    isEmpty,
    emptyMessage = "No results found.",
    children,
}: DataTableProps) {
    return (
        <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead className="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        {columns.map((col, i) => (
                            <th
                                key={i}
                                onClick={col.onClick}
                                className={`px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider ${col.onClick ? "cursor-pointer hover:text-gray-700 dark:hover:text-gray-200" : ""} ${col.className ?? ""}`}
                            >
                                {col.label}
                            </th>
                        ))}
                    </tr>
                </thead>
                <tbody className="divide-y divide-gray-100 dark:divide-gray-800">
                    {isEmpty && (
                        <tr>
                            <td
                                colSpan={colSpan}
                                className="px-4 py-8 text-center text-sm text-gray-400 dark:text-gray-500"
                            >
                                {emptyMessage}
                            </td>
                        </tr>
                    )}
                    {children}
                </tbody>
            </table>
        </div>
    );
}
