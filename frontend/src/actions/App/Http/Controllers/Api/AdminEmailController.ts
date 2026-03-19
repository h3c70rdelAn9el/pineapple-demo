import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\AdminEmailController::send
* @see app/Http/Controllers/Api/AdminEmailController.php:14
* @route '/api/admin/email-therapists'
*/
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/api/admin/email-therapists',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\AdminEmailController::send
* @see app/Http/Controllers/Api/AdminEmailController.php:14
* @route '/api/admin/email-therapists'
*/
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\AdminEmailController::send
* @see app/Http/Controllers/Api/AdminEmailController.php:14
* @route '/api/admin/email-therapists'
*/
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

const AdminEmailController = { send }

export default AdminEmailController