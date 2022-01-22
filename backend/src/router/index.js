import { createRouter, createWebHashHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Surveys from '../views/Surveys.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import DefautLayout from '../components/DefautLayout.vue'

const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        component: DefautLayout,
        children: [
            {
                path: '/dashboard',
                name: Dashboard,
                component: Dashboard
            },
            {
                path: '/Surveys',
                name: Surveys,
                component: Surveys
            }
        ]
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

export default router