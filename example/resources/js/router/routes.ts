import { RouteRecordRaw } from 'vue-router';
import Login from '@/pages/Login.vue'
import Dashboard from '@/pages/Dashboard.vue'
import Settings from '@/pages/Settings.vue'
import Profile from '@/pages/Profile.vue'
import auth from '@/middleware/auth';
import AuthLayout from '@/layouts/AuthLayout.vue'
import users from '@/router/models/users'

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'login',
        component: () => Login,
        meta: {
            layout: AuthLayout,
        },
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => Dashboard,
        beforeEnter: [auth],
    },
    {
        path: '/profile',
        name: 'profile',
        component: () => Profile,
        beforeEnter: [auth],
    },
    ...users,
    {
        path: '/settings',
        name: 'settings',
        component: () => Settings,
        beforeEnter: [auth],
    },
];

export default routes;
