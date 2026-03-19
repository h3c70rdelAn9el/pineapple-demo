import AuthController from './AuthController'
import DashboardController from './DashboardController'
import ClientController from './ClientController'
import TherapySessionController from './TherapySessionController'
import TherapistController from './TherapistController'
import UserController from './UserController'
import AdminEmailController from './AdminEmailController'
import StatsController from './StatsController'

const Api = {
    AuthController: Object.assign(AuthController, AuthController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    ClientController: Object.assign(ClientController, ClientController),
    TherapySessionController: Object.assign(TherapySessionController, TherapySessionController),
    TherapistController: Object.assign(TherapistController, TherapistController),
    UserController: Object.assign(UserController, UserController),
    AdminEmailController: Object.assign(AdminEmailController, AdminEmailController),
    StatsController: Object.assign(StatsController, StatsController),
}

export default Api