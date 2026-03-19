import MessagesController from './MessagesController'
import Api from './Api'

const Chatify = {
    MessagesController: Object.assign(MessagesController, MessagesController),
    Api: Object.assign(Api, Api),
}

export default Chatify