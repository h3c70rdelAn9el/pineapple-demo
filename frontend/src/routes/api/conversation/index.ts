import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

deleteMethod.definition = {
    methods: ["post"],
    url: '/chatify/api/deleteConversation',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
deleteMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

const conversation = {
    delete: Object.assign(deleteMethod, deleteMethod),
}

export default conversation