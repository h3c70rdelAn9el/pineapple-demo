import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::message
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:96
* @route '/messages/sendMessage'
*/
export const message = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

message.definition = {
    methods: ["post"],
    url: '/messages/sendMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::message
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:96
* @route '/messages/sendMessage'
*/
message.url = (options?: RouteQueryOptions) => {
    return message.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::message
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:96
* @route '/messages/sendMessage'
*/
message.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

const send = {
    message: Object.assign(message, message),
}

export default send