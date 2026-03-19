import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::auth
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:27
* @route '/messages/chat/auth'
*/
export const auth = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

auth.definition = {
    methods: ["post"],
    url: '/messages/chat/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::auth
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:27
* @route '/messages/chat/auth'
*/
auth.url = (options?: RouteQueryOptions) => {
    return auth.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::auth
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:27
* @route '/messages/chat/auth'
*/
auth.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

const pusher = {
    auth: Object.assign(auth, auth),
}

export default pusher