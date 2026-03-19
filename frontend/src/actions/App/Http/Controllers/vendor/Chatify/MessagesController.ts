import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
const index0cfd3f41dfd3107ef703f9657bc8a357 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index0cfd3f41dfd3107ef703f9657bc8a357.url(options),
    method: 'get',
})

index0cfd3f41dfd3107ef703f9657bc8a357.definition = {
    methods: ["get","head"],
    url: '/messages',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
index0cfd3f41dfd3107ef703f9657bc8a357.url = (options?: RouteQueryOptions) => {
    return index0cfd3f41dfd3107ef703f9657bc8a357.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
index0cfd3f41dfd3107ef703f9657bc8a357.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index0cfd3f41dfd3107ef703f9657bc8a357.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages'
*/
index0cfd3f41dfd3107ef703f9657bc8a357.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index0cfd3f41dfd3107ef703f9657bc8a357.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
const index283cc363c54a91a3bf46f0221649cc84 = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index283cc363c54a91a3bf46f0221649cc84.url(args, options),
    method: 'get',
})

index283cc363c54a91a3bf46f0221649cc84.definition = {
    methods: ["get","head"],
    url: '/messages/group/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
index283cc363c54a91a3bf46f0221649cc84.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return index283cc363c54a91a3bf46f0221649cc84.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
index283cc363c54a91a3bf46f0221649cc84.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index283cc363c54a91a3bf46f0221649cc84.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/group/{id}'
*/
index283cc363c54a91a3bf46f0221649cc84.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index283cc363c54a91a3bf46f0221649cc84.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
const indexb43afbb8d7b8fff06a6e1e8356ff63a1 = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexb43afbb8d7b8fff06a6e1e8356ff63a1.url(args, options),
    method: 'get',
})

indexb43afbb8d7b8fff06a6e1e8356ff63a1.definition = {
    methods: ["get","head"],
    url: '/messages/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
indexb43afbb8d7b8fff06a6e1e8356ff63a1.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return indexb43afbb8d7b8fff06a6e1e8356ff63a1.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
indexb43afbb8d7b8fff06a6e1e8356ff63a1.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexb43afbb8d7b8fff06a6e1e8356ff63a1.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::index
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:43
* @route '/messages/{id}'
*/
indexb43afbb8d7b8fff06a6e1e8356ff63a1.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: indexb43afbb8d7b8fff06a6e1e8356ff63a1.url(args, options),
    method: 'head',
})

export const index = {
    '/messages': index0cfd3f41dfd3107ef703f9657bc8a357,
    '/messages/group/{id}': index283cc363c54a91a3bf46f0221649cc84,
    '/messages/{id}': indexb43afbb8d7b8fff06a6e1e8356ff63a1,
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::idFetchData
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:60
* @route '/messages/idInfo'
*/
export const idFetchData = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idFetchData.url(options),
    method: 'post',
})

idFetchData.definition = {
    methods: ["post"],
    url: '/messages/idInfo',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::idFetchData
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:60
* @route '/messages/idInfo'
*/
idFetchData.url = (options?: RouteQueryOptions) => {
    return idFetchData.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::idFetchData
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:60
* @route '/messages/idInfo'
*/
idFetchData.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idFetchData.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::send
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:96
* @route '/messages/sendMessage'
*/
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/messages/sendMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::send
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:96
* @route '/messages/sendMessage'
*/
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::send
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:96
* @route '/messages/sendMessage'
*/
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::fetch
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:167
* @route '/messages/fetchMessages'
*/
export const fetch = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: fetch.url(options),
    method: 'post',
})

fetch.definition = {
    methods: ["post"],
    url: '/messages/fetchMessages',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::fetch
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:167
* @route '/messages/fetchMessages'
*/
fetch.url = (options?: RouteQueryOptions) => {
    return fetch.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::fetch
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:167
* @route '/messages/fetchMessages'
*/
fetch.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: fetch.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::download
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:81
* @route '/messages/download/{fileName}'
*/
export const download = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/messages/download/{fileName}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::download
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:81
* @route '/messages/download/{fileName}'
*/
download.url = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { fileName: args }
    }

    if (Array.isArray(args)) {
        args = {
            fileName: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        fileName: args.fileName,
    }

    return download.definition.url
            .replace('{fileName}', parsedArgs.fileName.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::download
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:81
* @route '/messages/download/{fileName}'
*/
download.get = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::download
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:81
* @route '/messages/download/{fileName}'
*/
download.head = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::pusherAuth
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:27
* @route '/messages/chat/auth'
*/
export const pusherAuth = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pusherAuth.url(options),
    method: 'post',
})

pusherAuth.definition = {
    methods: ["post"],
    url: '/messages/chat/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::pusherAuth
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:27
* @route '/messages/chat/auth'
*/
pusherAuth.url = (options?: RouteQueryOptions) => {
    return pusherAuth.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::pusherAuth
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:27
* @route '/messages/chat/auth'
*/
pusherAuth.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pusherAuth.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::seen
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:205
* @route '/messages/makeSeen'
*/
export const seen = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

seen.definition = {
    methods: ["post"],
    url: '/messages/makeSeen',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::seen
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:205
* @route '/messages/makeSeen'
*/
seen.url = (options?: RouteQueryOptions) => {
    return seen.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::seen
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:205
* @route '/messages/makeSeen'
*/
seen.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::getContacts
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
export const getContacts = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getContacts.url(options),
    method: 'get',
})

getContacts.definition = {
    methods: ["get","head"],
    url: '/messages/getContacts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::getContacts
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
getContacts.url = (options?: RouteQueryOptions) => {
    return getContacts.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::getContacts
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
getContacts.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getContacts.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::getContacts
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:221
* @route '/messages/getContacts'
*/
getContacts.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getContacts.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::updateContactItem
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:277
* @route '/messages/updateContacts'
*/
export const updateContactItem = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateContactItem.url(options),
    method: 'post',
})

updateContactItem.definition = {
    methods: ["post"],
    url: '/messages/updateContacts',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::updateContactItem
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:277
* @route '/messages/updateContacts'
*/
updateContactItem.url = (options?: RouteQueryOptions) => {
    return updateContactItem.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::updateContactItem
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:277
* @route '/messages/updateContacts'
*/
updateContactItem.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateContactItem.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::favorite
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:300
* @route '/messages/star'
*/
export const favorite = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorite.url(options),
    method: 'post',
})

favorite.definition = {
    methods: ["post"],
    url: '/messages/star',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::favorite
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:300
* @route '/messages/star'
*/
favorite.url = (options?: RouteQueryOptions) => {
    return favorite.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::favorite
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:300
* @route '/messages/star'
*/
favorite.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorite.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::getFavorites
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:319
* @route '/messages/favorites'
*/
export const getFavorites = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getFavorites.url(options),
    method: 'post',
})

getFavorites.definition = {
    methods: ["post"],
    url: '/messages/favorites',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::getFavorites
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:319
* @route '/messages/favorites'
*/
getFavorites.url = (options?: RouteQueryOptions) => {
    return getFavorites.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::getFavorites
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:319
* @route '/messages/favorites'
*/
getFavorites.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getFavorites.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
export const search = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

search.definition = {
    methods: ["get","head"],
    url: '/messages/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
search.url = (options?: RouteQueryOptions) => {
    return search.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
search.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::search
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:345
* @route '/messages/search'
*/
search.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: search.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::sharedPhotos
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:375
* @route '/messages/shared'
*/
export const sharedPhotos = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sharedPhotos.url(options),
    method: 'post',
})

sharedPhotos.definition = {
    methods: ["post"],
    url: '/messages/shared',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::sharedPhotos
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:375
* @route '/messages/shared'
*/
sharedPhotos.url = (options?: RouteQueryOptions) => {
    return sharedPhotos.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::sharedPhotos
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:375
* @route '/messages/shared'
*/
sharedPhotos.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sharedPhotos.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteConversation
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:399
* @route '/messages/deleteConversation'
*/
export const deleteConversation = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteConversation.url(options),
    method: 'post',
})

deleteConversation.definition = {
    methods: ["post"],
    url: '/messages/deleteConversation',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteConversation
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:399
* @route '/messages/deleteConversation'
*/
deleteConversation.url = (options?: RouteQueryOptions) => {
    return deleteConversation.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteConversation
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:399
* @route '/messages/deleteConversation'
*/
deleteConversation.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteConversation.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMessage
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:416
* @route '/messages/deleteMessage'
*/
export const deleteMessage = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMessage.url(options),
    method: 'post',
})

deleteMessage.definition = {
    methods: ["post"],
    url: '/messages/deleteMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMessage
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:416
* @route '/messages/deleteMessage'
*/
deleteMessage.url = (options?: RouteQueryOptions) => {
    return deleteMessage.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::deleteMessage
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:416
* @route '/messages/deleteMessage'
*/
deleteMessage.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMessage.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::updateSettings
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:427
* @route '/messages/updateSettings'
*/
export const updateSettings = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSettings.url(options),
    method: 'post',
})

updateSettings.definition = {
    methods: ["post"],
    url: '/messages/updateSettings',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::updateSettings
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:427
* @route '/messages/updateSettings'
*/
updateSettings.url = (options?: RouteQueryOptions) => {
    return updateSettings.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::updateSettings
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:427
* @route '/messages/updateSettings'
*/
updateSettings.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSettings.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::setActiveStatus
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:490
* @route '/messages/setActiveStatus'
*/
export const setActiveStatus = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setActiveStatus.url(options),
    method: 'post',
})

setActiveStatus.definition = {
    methods: ["post"],
    url: '/messages/setActiveStatus',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::setActiveStatus
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:490
* @route '/messages/setActiveStatus'
*/
setActiveStatus.url = (options?: RouteQueryOptions) => {
    return setActiveStatus.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\vendor\Chatify\MessagesController::setActiveStatus
* @see app/Http/Controllers/vendor/Chatify/MessagesController.php:490
* @route '/messages/setActiveStatus'
*/
setActiveStatus.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setActiveStatus.url(options),
    method: 'post',
})

const MessagesController = { index, idFetchData, send, fetch, download, pusherAuth, seen, getContacts, updateContactItem, favorite, getFavorites, search, sharedPhotos, deleteConversation, deleteMessage, updateSettings, setActiveStatus }

export default MessagesController