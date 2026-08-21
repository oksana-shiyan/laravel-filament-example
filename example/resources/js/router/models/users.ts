import { RouteRecordRaw } from 'vue-router';
import auth from '@/middleware/auth';
import Users from '@/pages/users/Users.vue'
import UserView from '@/pages/users/UserView.vue'

const users: Array<RouteRecordRaw> = [
    {
        path: '/users',
        beforeEnter: [auth],
        children: [
            {
                path: '',
                name: 'users',
                component: Users,
            },
            {
                path: ':id',
                name: 'single-user',
                component: UserView,
            },
        ],
    },
];

export default users;
