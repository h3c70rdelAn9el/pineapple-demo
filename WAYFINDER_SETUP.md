# Laravel Wayfinder Setup

## What We Did

Installed [Laravel Wayfinder](https://github.com/laravel/wayfinder) (`v0.1.14`) to generate type-safe TypeScript bindings from Laravel's PHP route/controller definitions directly into the Next.js frontend.

### Steps taken

1. **Installed the package** — `composer require laravel/wayfinder`
2. **Generated TypeScript files** — `php artisan wayfinder:generate --path=frontend/src`
    - Creates `frontend/src/actions/App/Http/Controllers/Api/` — one `.ts` file per controller
    - Creates `frontend/src/routes/` — named route helpers
    - Creates `frontend/src/wayfinder/index.ts` — core utility types
3. **Updated all 14 frontend files** to replace hardcoded URL strings with Wayfinder imports across every page, form, and the `AuthProvider`.
4. **Added a regeneration script** to the root `package.json`:
    ```bash
    npm run wayfinder
    ```

---

## Before vs After

```ts
// Before
api.get("/api/clients", { params: { sort, direction } });
api.delete(`/api/clients/${id}`);

// After
import * as ClientActions from "@/actions/App/Http/Controllers/Api/ClientController";

api.get(ClientActions.index.url(), { params: { sort, direction } });
api.delete(ClientActions.destroy.url(id));
```

---

## Benefits

- **Type safety** — controller method signatures (parameter names, types) are enforced at compile time. Passing the wrong ID type or missing a required route param is a TypeScript error, not a runtime 404.
- **Refactor confidence** — renaming a route or changing a URL parameter in PHP is immediately reflected as a TypeScript error in every file that uses it. No more grep-hunting for hardcoded strings.
- **Single source of truth** — URLs live only in `routes/api.php`. The frontend never duplicates them.
- **Discoverability** — IDE autocomplete shows every available controller action and its expected arguments, without reading PHP source.
- **Zero runtime overhead** — Wayfinder generates plain TypeScript functions at build time. No HTTP calls, no reflection, no bundle bloat.

---

## Keeping It Up to Date

Run after adding or changing any Laravel API routes:

```bash
npm run wayfinder
# or directly:
php artisan wayfinder:generate --path=frontend/src
```
