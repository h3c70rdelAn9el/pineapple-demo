import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
export const get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get.url(options),
    method: 'get',
})

get.definition = {
    methods: ["get","head"],
    url: '/chatify/api/getContacts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
get.url = (options?: RouteQueryOptions) => {
    return get.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
get.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
get.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: get.url(options),
    method: 'head',
})

const contacts = {
    get: Object.assign(get, get),
}

export default contacts