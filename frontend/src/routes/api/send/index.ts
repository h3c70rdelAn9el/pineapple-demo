import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::message
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
export const message = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

message.definition = {
    methods: ["post"],
    url: '/chatify/api/sendMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::message
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
message.url = (options?: RouteQueryOptions) => {
    return message.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\Api\MessagesController::message
* @see app/Http/Controllers/vendor/Chatify/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
message.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

const send = {
    message: Object.assign(message, message),
}

export default send