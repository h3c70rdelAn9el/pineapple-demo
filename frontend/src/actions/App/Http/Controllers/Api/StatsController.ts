import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\StatsController::index
* @see app/Http/Controllers/Api/StatsController.php:15
* @route '/api/admin/stats'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/stats',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\StatsController::index
* @see app/Http/Controllers/Api/StatsController.php:15
* @route '/api/admin/stats'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\StatsController::index
* @see app/Http/Controllers/Api/StatsController.php:15
* @route '/api/admin/stats'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\StatsController::index
* @see app/Http/Controllers/Api/StatsController.php:15
* @route '/api/admin/stats'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const StatsController = { index }

export default StatsController