# Modernize Laravel + Alpine App → Next.js + Laravel API

## Goal

Upgrade the current Laravel + Alpine.js app to:

- Latest Laravel version as an API backend
- Next.js as the primary frontend framework
- Replace Blade templates with Next.js pages and React components
- Remove Alpine.js completely
- Use Tailwind CSS in Next.js frontend

---

## 1. Audit the Current App

- Check Laravel version
- List all Blade templates
- Identify Alpine.js usage and interactive components
- Map which pages/components can be converted first
- Document which backend routes should become API endpoints

**Copilot guidance:** generate a table of Blade files, their Alpine components, and target API endpoints.

---

## 2. Upgrade Laravel

- Backup the current app (`git checkout -b upgrade-backup`)
- Update `composer.json` to latest Laravel version
- Run `composer update`
- Run migrations if needed (`php artisan migrate`)
- Convert necessary web routes to API routes (`routes/api.php`)
- Ensure controllers return JSON instead of Blade views
- Clear caches: `php artisan route:clear`, `php artisan view:clear`

**Copilot guidance:** list controllers/routes to convert and generate JSON output examples.

---

## 3. Set Up Next.js Frontend

- Create Next.js project (`npx create-next-app`)
- Install Tailwind CSS, React Query, Axios
- Scaffold initial pages corresponding to old Blade templates
- Create minimal test component/page to verify setup

**Copilot guidance:** scaffold Next.js pages for Dashboard, Profile, Settings, and connect to Laravel API endpoints.

---

## 4. Connect Next.js to Laravel API

- Use Axios or React Query for data fetching
- Replace Blade template data injection with API calls
- Fetch data using `getServerSideProps`, `getStaticProps`, or React Query hooks
- Implement error handling and loading states

**Copilot guidance:** generate API call utilities and React hooks for each endpoint.

---

## 5. Convert Alpine Components → React (Next.js)

- Replace modals, dropdowns, toggles with React `useState` and `useEffect`
- Replace Blade loops with `.map()` over API data
- Test each component incrementally within Next.js pages

**Copilot guidance:** scaffold React equivalents of all Alpine components as Next.js components.

---

## 6. Cleanup

- Remove Alpine.js references (`npm uninstall alpinejs`)
- Delete unused Blade templates
- Refactor Tailwind/CSS in Next.js
- Run regression tests on all converted pages

**Copilot guidance:** generate a cleanup checklist for removing Alpine.js and old Blade files safely.

---

## 7. Optional Enhancements

- SPA authentication with Laravel Sanctum or JWT for Next.js
- Lazy-loading for large React components
- Document converted pages, components, and API endpoints
- Optimize API requests for Next.js frontend

**Copilot guidance:** scaffold authentication utilities and example Next.js pages for login/register/dashboard.

---

## 8. Folder & Component Structure (Suggested)

```
frontend/ (Next.js)
└─ app/ or pages/
   ├─ components/
   │   ├─ Modal.jsx
   │   ├─ Dropdown.jsx
   │   └─ ...
   └─ pages/
       ├─ dashboard.jsx
       ├─ profile.jsx
       ├─ settings.jsx
       └─ ...
backend/ (Laravel API)
└─ routes/
   └─ api.php
```

**Copilot guidance:** generate missing folders/components in Next.js and connect them to Laravel API routes.

---

### Notes for Copilot

- Work incrementally — one Blade page → one Next.js page/component
- Replace Blade templates with Next.js pages while preserving backend data logic
- Scaffold React components, API calls, and Next.js routing automatically
- Keep Tailwind classes from original templates when possible
- Document each converted page/component and API endpoint
