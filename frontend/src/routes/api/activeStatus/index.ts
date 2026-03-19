import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::set
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
export const set = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

set.definition = {
    methods: ["post"],
    url: '/chatify/api/setActiveStatus',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::set
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
set.url = (options?: RouteQueryOptions) => {
    return set.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::set
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
set.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

const activeStatus = {
    set: Object.assign(set, set),
}

export default activeStatus