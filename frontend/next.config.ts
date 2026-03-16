import type { NextConfig } from "next";

const laravelUrl = process.env.LARAVEL_URL || "http://localhost:8000";

const nextConfig: NextConfig = {
  async rewrites() {
    return [
      {
        source: "/sanctum/:path*",
        destination: `${laravelUrl}/sanctum/:path*`,
      },
      {
        source: "/api/:path*",
        destination: `${laravelUrl}/api/:path*`,
      },
    ];
  },
};

export default nextConfig;
