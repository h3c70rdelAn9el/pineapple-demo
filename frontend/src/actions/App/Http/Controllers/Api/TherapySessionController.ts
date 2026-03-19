import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\TherapySessionController::index
* @see app/Http/Controllers/Api/TherapySessionController.php:22
* @route '/api/sessions'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/sessions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\TherapySessionController::index
* @see app/Http/Controllers/Api/TherapySessionController.php:22
* @route '/api/sessions'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\TherapySessionController::index
* @see app/Http/Controllers/Api/TherapySessionController.php:22
* @route '/api/sessions'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\TherapySessionController::index
* @see app/Http/Controllers/Api/TherapySessionController.php:22
* @route '/api/sessions'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\TherapySessionController::store
* @see app/Http/Controllers/Api/TherapySessionController.php:85
* @route '/api/sessions'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/sessions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\TherapySessionController::store
* @see app/Http/Controllers/Api/TherapySessionController.php:85
* @route '/api/sessions'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\TherapySessionController::store
* @see app/Http/Controllers/Api/TherapySessionController.php:85
* @route '/api/sessions'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Api\TherapySessionController::show
* @see app/Http/Controllers/Api/TherapySessionController.php:62
* @route '/api/sessions/{id}'
*/
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/sessions/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\TherapySessionController::show
* @see app/Http/Controllers/Api/TherapySessionController.php:62
* @route '/api/sessions/{id}'
*/
show.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return show.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\TherapySessionController::show
* @see app/Http/Controllers/Api/TherapySessionController.php:62
* @route '/api/sessions/{id}'
*/
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\TherapySessionController::show
* @see app/Http/Controllers/Api/TherapySessionController.php:62
* @route '/api/sessions/{id}'
*/
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\TherapySessionController::update
* @see app/Http/Controllers/Api/TherapySessionController.php:168
* @route '/api/sessions/{therapySession}'
*/
export const update = (args: { therapySession: number | { id: number } } | [therapySession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/api/sessions/{therapySession}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Api\TherapySessionController::update
* @see app/Http/Controllers/Api/TherapySessionController.php:168
* @route '/api/sessions/{therapySession}'
*/
update.url = (args: { therapySession: number | { id: number } } | [therapySession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { therapySession: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { therapySession: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            therapySession: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        therapySession: typeof args.therapySession === 'object'
        ? args.therapySession.id
        : args.therapySession,
    }

    return update.definition.url
            .replace('{therapySession}', parsedArgs.therapySession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\TherapySessionController::update
* @see app/Http/Controllers/Api/TherapySessionController.php:168
* @route '/api/sessions/{therapySession}'
*/
update.patch = (args: { therapySession: number | { id: number } } | [therapySession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Api\TherapySessionController::destroy
* @see app/Http/Controllers/Api/TherapySessionController.php:179
* @route '/api/sessions/{therapySession}'
*/
export const destroy = (args: { therapySession: number | { id: number } } | [therapySession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/sessions/{therapySession}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Api\TherapySessionController::destroy
* @see app/Http/Controllers/Api/TherapySessionController.php:179
* @route '/api/sessions/{therapySession}'
*/
destroy.url = (args: { therapySession: number | { id: number } } | [therapySession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { therapySession: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { therapySession: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            therapySession: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        therapySession: typeof args.therapySession === 'object'
        ? args.therapySession.id
        : args.therapySession,
    }

    return destroy.definition.url
            .replace('{therapySession}', parsedArgs.therapySession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\TherapySessionController::destroy
* @see app/Http/Controllers/Api/TherapySessionController.php:179
* @route '/api/sessions/{therapySession}'
*/
destroy.delete = (args: { therapySession: number | { id: number } } | [therapySession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const TherapySessionController = { index, store, show, update, destroy }

export default TherapySessionController