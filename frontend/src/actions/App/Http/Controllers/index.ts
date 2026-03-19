import vendor from './vendor'
import Api from './Api'

const Controllers = {
    vendor: Object.assign(vendor, vendor),
    Api: Object.assign(Api, Api),
}

export default Controllers