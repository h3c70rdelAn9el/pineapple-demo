import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::update
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/chatify/api/updateSettings',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::update
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::update
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

const avatar = {
    update: Object.assign(update, update),
}

export default avatar