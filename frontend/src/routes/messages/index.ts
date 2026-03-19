import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::seen
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:205
* @route '/messages/makeSeen'
*/
export const seen = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

seen.definition = {
    methods: ["post"],
    url: '/messages/makeSeen',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::seen
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:205
* @route '/messages/makeSeen'
*/
seen.url = (options?: RouteQueryOptions) => {
    return seen.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::seen
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:205
* @route '/messages/makeSeen'
*/
seen.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

const messages = {
    seen: Object.assign(seen, seen),
}

export default messages