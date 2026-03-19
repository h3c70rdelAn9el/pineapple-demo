import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::messages
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:167
* @route '/messages/fetchMessages'
*/
export const messages = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: messages.url(options),
    method: 'post',
})

messages.definition = {
    methods: ["post"],
    url: '/messages/fetchMessages',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::messages
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:167
* @route '/messages/fetchMessages'
*/
messages.url = (options?: RouteQueryOptions) => {
    return messages.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::messages
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:167
* @route '/messages/fetchMessages'
*/
messages.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: messages.url(options),
    method: 'post',
})

const fetch = {
    messages: Object.assign(messages, messages),
}

export default fetch