import Vue from 'vue';
import Router from 'vue-router';
import Buzzer from '../components/Buzzer.vue'
import Dashboard from '../admin/views/Dashboard'
import Settings from '../admin/views/Settings'
import DefaultContainer from '../admin/containers/DefaultContainer'
import Logout from '../admin/views/Logout'

Vue.use(Router)

export default new Router({
    mode: 'hash',
    linkActiveClass: 'open active',
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Buzzer
        },
        {
            path: '/admin',
            redirect: '/admin/dashboard',
            name: 'Admin',
            component: DefaultContainer,
            children: [
                {
                    path: '/admin/dashboard',
                    component: Dashboard,
                    name: Dashboard
                },
                {
                    path: '/admin/settings',
                    name: Settings,
                    component: Settings
                },
                {
                    path: '/admin/logout',
                    name: Logout,
                    component: Logout
                }
            ]
        }
    ]
});