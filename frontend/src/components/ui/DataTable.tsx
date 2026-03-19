import { ReactNode } from "react";

interface Column {
    label: ReactNode;
    className?: string;
    /** If provided, clicking this column header calls onSort with this key */
    sortKey?: string;
}

interface DataTableProps {
    columns: Column[];
    colSpan: number;
    isEmpty: boolean;
    emptyMessage?: string;
    /** Current sort field key */
    sort?: string;
    /** Current sort direction */
    direction?: "asc" | "desc";
    /** Called with the sortKey when a sortable column header is clicked */
    onSort?: (key: string) => void;
    children: ReactNode;
}

function SortChevron({
    active,
    direction,
}: {
    active: boolean;
    direction?: "asc" | "desc";
}) {
    if (active) {
        return direction === "asc" ? (
            <svg
                xmlns="http://www.w3.org/2000/svg"
                className="inline ml-1 h-3 w-3 text-indigo-500"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fillRule="evenodd"
                    d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                    clipRule="evenodd"
                />
            </svg>
        ) : (
            <svg
                xmlns="http://www.w3.org/2000/svg"
                className="inline ml-1 h-3 w-3 text-indigo-500"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fillRule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clipRule="evenodd"
                />
            </svg>
        );
    }

    // Inactive sortable column — neutral double chevron
    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            className="inline ml-1 h-3 w-3 text-gray-300 dark:text-gray-600"
            viewBox="0 0 20 20"
            fill="currentColor"
        >
            <path
                fillRule="evenodd"
                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                clipRule="evenodd"
            />
        </svg>
    );
}

export default function DataTable({
    columns,
    colSpan,
    isEmpty,
    emptyMessage = "No results found.",
    sort,
    direction,
    onSort,
    children,
}: DataTableProps) {
    return (
        <div className="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead className="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        {columns.map((col, i) => {
                            const isSortable = !!col.sortKey && !!onSort;
                            const isActive = col.sortKey === sort;
                            return (
                                <th
                                    key={i}
                                    onClick={
                                        isSortable
                                            ? () => onSort!(col.sortKey!)
                                            : undefined
                                    }
                                    className={`px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider select-none ${isSortable ? "cursor-pointer hover:text-gray-700 dark:hover:text-gray-200" : ""} ${col.className ?? ""}`}
                                >
                                    {col.label}
                                    {isSortable && (
                                        <SortChevron
                                            active={isActive}
                                            direction={
                                                isActive ? direction : undefined
                                            }
                                        />
                                    )}
                                </th>
                            );
                        })}
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
