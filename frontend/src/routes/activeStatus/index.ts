import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::set
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:490
* @route '/messages/setActiveStatus'
*/
export const set = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

set.definition = {
    methods: ["post"],
    url: '/messages/setActiveStatus',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::set
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:490
* @route '/messages/setActiveStatus'
*/
set.url = (options?: RouteQueryOptions) => {
    return set.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::set
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:490
* @route '/messages/setActiveStatus'
*/
set.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

const activeStatus = {
    set: Object.assign(set, set),
}

export default activeStatus