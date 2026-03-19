import Fortify from './Fortify'
import Jetstream from './Jetstream'
import Sanctum from './Sanctum'

const Laravel = {
    Fortify: Object.assign(Fortify, Fortify),
    Jetstream: Object.assign(Jetstream, Jetstream),
    Sanctum: Object.assign(Sanctum, Sanctum),
}

export default Laravel