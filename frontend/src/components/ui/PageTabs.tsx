interface Tab<T extends string = string> {
    key: T;
    label: string;
    count?: number;
}

interface PageTabsProps<T extends string = string> {
    tabs: Tab<T>[];
    activeTab: T;
    onChange: (key: T) => void;
}

export default function PageTabs<T extends string = string>({
    tabs,
    activeTab,
    onChange,
}: PageTabsProps<T>) {
    return (
        <div className="border-b border-gray-200 dark:border-gray-700">
            <nav className="flex space-x-4 -mb-px">
                {tabs.map((t) => (
                    <button
                        key={t.key}
                        onClick={() => onChange(t.key)}
                        className={`py-2 px-1 border-b-2 text-sm font-medium transition-colors ${
                            activeTab === t.key
                                ? "border-indigo-500 text-indigo-600"
                                : "border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600"
                        }`}
                    >
                        {t.label}
                        {t.count !== undefined && (
                            <span className="ml-1.5 text-xs text-gray-400 dark:text-gray-500">
                                ({t.count})
                            </span>
                        )}
                    </button>
                ))}
            </nav>
        </div>
    );
}
