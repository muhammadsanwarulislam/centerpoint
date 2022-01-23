import { createRouter, createWebHashHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Surveys from '../views/Surveys.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import DefautLayout from '../components/DefautLayout.vue'
import AuthLayout from '../components/AuthLayout.vue'
import store from '../store'

const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        component: DefautLayout,
        meta: { 
            requiresAuth: true
        },
        children: [
            {
                path: '/dashboard',
                name: Dashboard,
                component: Dashboard
            },
            {
                path: '/surveys',
                name: Surveys,
                component: Surveys
            }
        ]
    },
    {
        path: '/auth',
        redirect: '/login',
        name: 'Auth',
        component: AuthLayout,
        meta: { isGuest: true },
        children: [
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
    },
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

router.beforeEach(async (to, from) => {
    if (to.meta.requiresAuth && !store.state.user.token) return '/login'
    else if (store.state.user.token && (to.meta.isGuest)) return '/dashboard'
  })

export default router