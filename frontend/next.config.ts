import type { NextConfig } from "next";

// nginx on la-pina.test routes /api/* and /sanctum/* to Laravel PHP,
// and everything else to this Next.js dev server on port 3000.
const nextConfig: NextConfig = {};

export default nextConfig;
