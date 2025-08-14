<laravel-boost-guidelines>
=== core rules ===

# Laravel Boost Guidelines
The Laravel Boost Guidelines are specifically curated by Laravel maintainers for this project. These guidelines should be followed closely to help enhance the user's experience and satisfaction.

## Foundational Context
This project is a Laravel app and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure we abide by these specific packages & versions.

- php - 8.3.22
- laravel/framework (LARAVEL) - v10
- laravel/prompts (PROMPTS) - v0
- laravel/scout (SCOUT) - v10
- livewire/livewire (LIVEWIRE) - v2
- laravel/pint (PINT) - v1
- alpinejs (ALPINEJS) - v3
- tailwindcss (TAILWINDCSS) - v3


## Conventions
- You must follow all existing code conventions used in this project. When creating or editing a file, check sibling files for the correct structure, approach, naming.
- Use descriptive names. For example, `isRegisteredForDiscounts` not `discount()`.

## Verification Scripts
- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Project Structure and Architecture
- Stick to existing directory structure - no new base folders without approval.
- No dependency changes without approval.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.


=== boost/core rules ===

## Boost
- Boost MCP comes with powerful tools designed specifically for this application. Use them.

## URLs
- Whenever you share a project URL with the user you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain / IP, and port.

## Artisan
- Use the `list-artisan-commands` tool when you need to call an artisan command to triple check the available parameters.

## Tinker / Debugging
- You should use the `tinker` tool from Boost MCP when you need to run PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading browser logs with the `browser-logs` tool
- You can read browser logs, errors, and exceptions with the `browser-logs` tool from Boost.
- Only recent browser logs will be useful, ignore old logs.

## Searching documentation (critically important)
- Boost comes with a powerful `search-docs` tool you should use before any other approaches. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation specific for the user's circumstance. You should pass an array of packages to filter docs on if you know you need docs for particular packages.
- The 'search-docs' tool is perfect for all Laravel related packages. Laravel, Inertia, Pest, Livewire, Nova, Nightwatch, etc..
- You must use this tool to search for Laravel-ecosystem docs before falling back to other approaches.
- Search the docs before making code changes to ensure we are approaching this in the correct way.
- Use multiple broad simple topic based queries to start, i.e. `rate limiting##routing rate limiting##routing`.

### Available search syntax
- You can and should pass multiple queries at once, the most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit"
3. Quoted Phrases (Exact Position) - query="infinite scroll - Words must be adjacent and in that order
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit"
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms


=== php/core rules ===

- Always use curly braces for control structures, even if it has one line.

## Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
<code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters.

## Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.
<code-snippet name="Explicit return types and method params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over comments. Use zero comments, unless there is something _very_ complex going on.

## PHPDoc blocks
- Add useful array shape definitions for arrays

## Enums
- Keys in an Enum should be UPPERCASE and words separated with an underscore. i.e. `FAVORITE_PERSON`, `BEST_LAKE`, `MONTHLY`


=== laravel/core rules ===

## Do Things the Laravel Way
- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available artisan commands with the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `artisan make:class`.

## Database
- **Model relationships**: Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- **Eloquent first approach**: Use Eloquent models and relationships before suggesting raw database queries
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- **DB N+1**: Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

## Controllers and validation
- **Form request validation**: Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- **Validation rule style**: Check sibling form requests to see if the project uses array or string based validation rules.

## Model Creation
- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, use `list-artisan-commands` to check the available options to `php artisan make:model`

## APIs and Eloquent Resources
- For APIs, default to using Eloquent API Resources and API versioning, unless existing API routes do not, then you should follow existing convention.

## Queues
- **Job and queue patterns**: Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

## Authentication and Authorization
- Use Laravel built-in authentication and authorization features (Gates, Policies, Sanctum).

## Config
- **Use environment variables** via config files, never `env()` directly. Always use `config('app.name')` not `env('APP_NAME')`.

## Testing
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.

## Vite Error
- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.


=== laravel/v10 rules ===

## Laravel 10
- Use `search-docs` tool, if available, to get version specific documentation.

- Middleware typically lives in `app/Http/Middleware/` and service providers in `app/Providers/`.
- There is no `bootstrap/app.php` application configuration in Laravel 10:
    - Middleware registration happens in `app/Http/Kernel.php`
    - Exception handling is in `app/Exceptions/Handler.php`
    - Console commands and schedule register in `app/Console/Kernel.php`
    - Rate limits likely exist in `RouteServiceProvider` or `app/Http/Kernel.php`
- Model Casts: you must use `protected $casts = [];` not the `casts()` method. The `casts()` method isn't available on models in Laravel 10.



=== livewire/core rules ===

## Livewire Core


=== pint/core rules ===

## Pint Code Formatting Core
- You must run `vendor/bin/pint` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.


=== tailwindcss/core rules ===

- If existing pages and components support dark mode, new pages and components must support dark mode in a similar way.


=== tests rules ===

- Every change must be programmatically tested. Write a new test, or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test` with a specific filename or filter.
</laravel-boost-guidelines>