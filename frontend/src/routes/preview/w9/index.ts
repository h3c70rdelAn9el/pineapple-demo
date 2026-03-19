import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see routes/web.php:17
* @route '/preview-w9-email'
*/
export const email = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: email.url(options),
    method: 'get',
})

email.definition = {
    methods: ["get","head"],
    url: '/preview-w9-email',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:17
* @route '/preview-w9-email'
*/
email.url = (options?: RouteQueryOptions) => {
    return email.definition.url + queryParams(options)
}

/**
* @see routes/web.php:17
* @route '/preview-w9-email'
*/
email.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: email.url(options),
    method: 'get',
})

/**
* @see routes/web.php:17
* @route '/preview-w9-email'
*/
email.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: email.url(options),
    method: 'head',
})

const w9 = {
    email: Object.assign(email, email),
}

export default w9