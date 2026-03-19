import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
export const get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get.url(options),
    method: 'get',
})

get.definition = {
    methods: ["get","head"],
    url: '/messages/getContacts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
get.url = (options?: RouteQueryOptions) => {
    return get.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
get.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::get
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
get.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: get.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::update
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:277
* @route '/messages/updateContacts'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/messages/updateContacts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::update
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:277
* @route '/messages/updateContacts'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::update
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:277
* @route '/messages/updateContacts'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

const contacts = {
    get: Object.assign(get, get),
    update: Object.assign(update, update),
}

export default contacts