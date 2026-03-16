interface BadgeProps {
    children: React.ReactNode;
    variant?: "green" | "red" | "yellow" | "blue" | "gray";
    className?: string;
}

const variantClasses = {
    green: "bg-green-100 text-green-800",
    red: "bg-red-100 text-red-800",
    yellow: "bg-yellow-100 text-yellow-800",
    blue: "bg-blue-100 text-blue-800",
    gray: "bg-gray-100 text-gray-800",
};

export default function Badge({
    children,
    variant = "gray",
    className = "",
}: BadgeProps) {
    return (
        <span
            className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${variantClasses[variant]} ${className}`}
        >
            {children}
        </span>
    );
}
