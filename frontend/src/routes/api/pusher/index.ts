import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::auth
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:28
* @route '/chatify/api/chat/auth'
*/
export const auth = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

auth.definition = {
    methods: ["post"],
    url: '/chatify/api/chat/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::auth
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:28
* @route '/chatify/api/chat/auth'
*/
auth.url = (options?: RouteQueryOptions) => {
    return auth.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::auth
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:28
* @route '/chatify/api/chat/auth'
*/
auth.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

const pusher = {
    auth: Object.assign(auth, auth),
}

export default pusher