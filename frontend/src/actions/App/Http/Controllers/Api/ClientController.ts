import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    applyUrlDefaults,
} from "./../../../../../wayfinder";
/**
 * @see \App\Http\Controllers\Api\ClientController::index
 * @see app/Http/Controllers/Api/ClientController.php:23
 * @route '/api/clients'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<"get"> => ({
    url: index.url(options),
    method: "get",
});

index.definition = {
    methods: ["get", "head"],
    url: "/api/clients",
} satisfies RouteDefinition<["get", "head"]>;

/**
 * @see \App\Http\Controllers\Api\ClientController::index
 * @see app/Http/Controllers/Api/ClientController.php:23
 * @route '/api/clients'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\Api\ClientController::index
 * @see app/Http/Controllers/Api/ClientController.php:23
 * @route '/api/clients'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<"get"> => ({
    url: index.url(options),
    method: "get",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::index
 * @see app/Http/Controllers/Api/ClientController.php:23
 * @route '/api/clients'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<"head"> => ({
    url: index.url(options),
    method: "head",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::create
 * @see app/Http/Controllers/Api/ClientController.php:117
 * @route '/api/clients/create'
 */
export const create = (
    options?: RouteQueryOptions,
): RouteDefinition<"get"> => ({
    url: create.url(options),
    method: "get",
});

create.definition = {
    methods: ["get", "head"],
    url: "/api/clients/create",
} satisfies RouteDefinition<["get", "head"]>;

/**
 * @see \App\Http\Controllers\Api\ClientController::create
 * @see app/Http/Controllers/Api/ClientController.php:117
 * @route '/api/clients/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\Api\ClientController::create
 * @see app/Http/Controllers/Api/ClientController.php:117
 * @route '/api/clients/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<"get"> => ({
    url: create.url(options),
    method: "get",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::create
 * @see app/Http/Controllers/Api/ClientController.php:117
 * @route '/api/clients/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<"head"> => ({
    url: create.url(options),
    method: "head",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::store
 * @see app/Http/Controllers/Api/ClientController.php:143
 * @route '/api/clients'
 */
export const store = (
    options?: RouteQueryOptions,
): RouteDefinition<"post"> => ({
    url: store.url(options),
    method: "post",
});

store.definition = {
    methods: ["post"],
    url: "/api/clients",
} satisfies RouteDefinition<["post"]>;

/**
 * @see \App\Http\Controllers\Api\ClientController::store
 * @see app/Http/Controllers/Api/ClientController.php:143
 * @route '/api/clients'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\Api\ClientController::store
 * @see app/Http/Controllers/Api/ClientController.php:143
 * @route '/api/clients'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<"post"> => ({
    url: store.url(options),
    method: "post",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::show
 * @see app/Http/Controllers/Api/ClientController.php:100
 * @route '/api/clients/{id}'
 */
export const show = (
    args: { id: string | number } | [id: string | number] | string | number,
    options?: RouteQueryOptions,
): RouteDefinition<"get"> => ({
    url: show.url(args, options),
    method: "get",
});

show.definition = {
    methods: ["get", "head"],
    url: "/api/clients/{id}",
} satisfies RouteDefinition<["get", "head"]>;

/**
 * @see \App\Http\Controllers\Api\ClientController::show
 * @see app/Http/Controllers/Api/ClientController.php:100
 * @route '/api/clients/{id}'
 */
show.url = (
    args: { id: string | number } | [id: string | number] | string | number,
    options?: RouteQueryOptions,
) => {
    if (typeof args === "string" || typeof args === "number") {
        args = { id: args };
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        id: args.id,
    };

    return (
        show.definition.url
            .replace("{id}", parsedArgs.id.toString())
            .replace(/\/+$/, "") + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\Api\ClientController::show
 * @see app/Http/Controllers/Api/ClientController.php:100
 * @route '/api/clients/{id}'
 */
show.get = (
    args: { id: string | number } | [id: string | number] | string | number,
    options?: RouteQueryOptions,
): RouteDefinition<"get"> => ({
    url: show.url(args, options),
    method: "get",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::show
 * @see app/Http/Controllers/Api/ClientController.php:100
 * @route '/api/clients/{id}'
 */
show.head = (
    args: { id: string | number } | [id: string | number] | string | number,
    options?: RouteQueryOptions,
): RouteDefinition<"head"> => ({
    url: show.url(args, options),
    method: "head",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::update
 * @see app/Http/Controllers/Api/ClientController.php:209
 * @route '/api/clients/{client}'
 */
export const update = (
    args:
        | { client: number | { id: number } }
        | [client: number | { id: number }]
        | number
        | { id: number },
    options?: RouteQueryOptions,
): RouteDefinition<"put"> => ({
    url: update.url(args, options),
    method: "put",
});

update.definition = {
    methods: ["put"],
    url: "/api/clients/{client}",
} satisfies RouteDefinition<["put"]>;

/**
 * @see \App\Http\Controllers\Api\ClientController::update
 * @see app/Http/Controllers/Api/ClientController.php:209
 * @route '/api/clients/{client}'
 */
update.url = (
    args:
        | { client: number | { id: number } }
        | [client: number | { id: number }]
        | number
        | { id: number },
    options?: RouteQueryOptions,
) => {
    if (typeof args === "string" || typeof args === "number") {
        args = { client: args };
    }

    if (typeof args === "object" && !Array.isArray(args) && "id" in args) {
        args = { client: args.id };
    }

    if (Array.isArray(args)) {
        args = {
            client: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        client: typeof args.client === "object" ? args.client.id : args.client,
    };

    return (
        update.definition.url
            .replace("{client}", parsedArgs.client.toString())
            .replace(/\/+$/, "") + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\Api\ClientController::update
 * @see app/Http/Controllers/Api/ClientController.php:209
 * @route '/api/clients/{client}'
 */
update.put = (
    args:
        | { client: number | { id: number } }
        | [client: number | { id: number }]
        | number
        | { id: number },
    options?: RouteQueryOptions,
): RouteDefinition<"put"> => ({
    url: update.url(args, options),
    method: "put",
});

/**
 * @see \App\Http\Controllers\Api\ClientController::destroy
 * @see app/Http/Controllers/Api/ClientController.php:287
 * @route '/api/clients/{client}'
 */
export const destroy = (
    args:
        | { client: number | { id: number } }
        | [client: number | { id: number }]
        | number
        | { id: number },
    options?: RouteQueryOptions,
): RouteDefinition<"delete"> => ({
    url: destroy.url(args, options),
    method: "delete",
});

destroy.definition = {
    methods: ["delete"],
    url: "/api/clients/{client}",
} satisfies RouteDefinition<["delete"]>;

/**
 * @see \App\Http\Controllers\Api\ClientController::destroy
 * @see app/Http/Controllers/Api/ClientController.php:287
 * @route '/api/clients/{client}'
 */
destroy.url = (
    args:
        | { client: number | { id: number } }
        | [client: number | { id: number }]
        | number
        | { id: number },
    options?: RouteQueryOptions,
) => {
    if (typeof args === "string" || typeof args === "number") {
        args = { client: args };
    }

    if (typeof args === "object" && !Array.isArray(args) && "id" in args) {
        args = { client: args.id };
    }

    if (Array.isArray(args)) {
        args = {
            client: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        client: typeof args.client === "object" ? args.client.id : args.client,
    };

    return (
        destroy.definition.url
            .replace("{client}", parsedArgs.client.toString())
            .replace(/\/+$/, "") + queryParams(options)
    );
};

/**
 * @see \App\Http\Controllers\Api\ClientController::destroy
 * @see app/Http/Controllers/Api/ClientController.php:287
 * @route '/api/clients/{client}'
 */
destroy.delete = (
    args:
        | { client: number | { id: number } }
        | [client: number | { id: number }]
        | number
        | { id: number },
    options?: RouteQueryOptions,
): RouteDefinition<"delete"> => ({
    url: destroy.url(args, options),
    method: "delete",
});

const ClientController = { index, create, store, show, update, destroy };

export default ClientController;
