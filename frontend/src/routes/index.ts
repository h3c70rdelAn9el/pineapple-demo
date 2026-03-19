import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
export const register = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

register.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
register.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
register.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: register.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::messages
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
export const messages = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: messages.url(options),
    method: 'get',
})

messages.definition = {
    methods: ["get","head"],
    url: '/messages',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::messages
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
messages.url = (options?: RouteQueryOptions) => {
    return messages.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::messages
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
messages.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: messages.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::messages
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
messages.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: messages.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::star
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:300
* @route '/messages/star'
*/
export const star = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: star.url(options),
    method: 'post',
})

star.definition = {
    methods: ["post"],
    url: '/messages/star',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::star
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:300
* @route '/messages/star'
*/
star.url = (options?: RouteQueryOptions) => {
    return star.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::star
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:300
* @route '/messages/star'
*/
star.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: star.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::favorites
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:319
* @route '/messages/favorites'
*/
export const favorites = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorites.url(options),
    method: 'post',
})

favorites.definition = {
    methods: ["post"],
    url: '/messages/favorites',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::favorites
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:319
* @route '/messages/favorites'
*/
favorites.url = (options?: RouteQueryOptions) => {
    return favorites.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::favorites
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:319
* @route '/messages/favorites'
*/
favorites.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorites.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
export const search = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

search.definition = {
    methods: ["get","head"],
    url: '/messages/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
search.url = (options?: RouteQueryOptions) => {
    return search.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
search.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
search.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: search.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::shared
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:375
* @route '/messages/shared'
*/
export const shared = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: shared.url(options),
    method: 'post',
})

shared.definition = {
    methods: ["post"],
    url: '/messages/shared',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::shared
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:375
* @route '/messages/shared'
*/
shared.url = (options?: RouteQueryOptions) => {
    return shared.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::shared
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:375
* @route '/messages/shared'
*/
shared.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: shared.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::group
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
export const group = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: group.url(args, options),
    method: 'get',
})

group.definition = {
    methods: ["get","head"],
    url: '/messages/group/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::group
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
group.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return group.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::group
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
group.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: group.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::group
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
group.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: group.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::user
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
export const user = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: user.url(args, options),
    method: 'get',
})

user.definition = {
    methods: ["get","head"],
    url: '/messages/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::user
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
user.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return user.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::user
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
user.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: user.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::user
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
user.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: user.url(args, options),
    method: 'head',
})

