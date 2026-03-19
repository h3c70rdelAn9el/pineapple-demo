import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:399
* @route '/messages/deleteConversation'
*/
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

deleteMethod.definition = {
    methods: ["post"],
    url: '/messages/deleteConversation',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:399
* @route '/messages/deleteConversation'
*/
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMethod
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:399
* @route '/messages/deleteConversation'
*/
deleteMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

const conversation = {
    delete: Object.assign(deleteMethod, deleteMethod),
}

export default conversation