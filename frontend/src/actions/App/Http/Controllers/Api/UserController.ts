import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\UserController::updateProfile
* @see app/Http/Controllers/Api/UserController.php:11
* @route '/api/profile'
*/
export const updateProfile = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateProfile.url(options),
    method: 'put',
})

updateProfile.definition = {
    methods: ["put"],
    url: '/api/profile',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Api\UserController::updateProfile
* @see app/Http/Controllers/Api/UserController.php:11
* @route '/api/profile'
*/
updateProfile.url = (options?: RouteQueryOptions) => {
    return updateProfile.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\UserController::updateProfile
* @see app/Http/Controllers/Api/UserController.php:11
* @route '/api/profile'
*/
updateProfile.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateProfile.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Api\UserController::updateGender
* @see app/Http/Controllers/Api/UserController.php:25
* @route '/api/profile/gender'
*/
export const updateGender = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateGender.url(options),
    method: 'post',
})

updateGender.definition = {
    methods: ["post"],
    url: '/api/profile/gender',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Api\UserController::updateGender
* @see app/Http/Controllers/Api/UserController.php:25
* @route '/api/profile/gender'
*/
updateGender.url = (options?: RouteQueryOptions) => {
    return updateGender.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\UserController::updateGender
* @see app/Http/Controllers/Api/UserController.php:25
* @route '/api/profile/gender'
*/
updateGender.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateGender.url(options),
    method: 'post',
})

const UserController = { updateProfile, updateGender }

export default UserController