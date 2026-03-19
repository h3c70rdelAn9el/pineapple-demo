import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:416
* @route '/messages/deleteMessage'
*/
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

deleteMethod.definition = {
    methods: ["post"],
    url: '/messages/deleteMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:416
* @route '/messages/deleteMessage'
*/
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:416
* @route '/messages/deleteMessage'
*/
deleteMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

const message = {
    delete: Object.assign(deleteMethod, deleteMethod),
}

export default message