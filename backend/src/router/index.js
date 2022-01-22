import { createRouter, createWebHashHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Surveys from '../views/Surveys.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import DefautLayout from '../components/DefautLayout.vue'
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

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) next({ name: 'Login' })
    else if (store.state.user.token && (to.name === 'Login' || to.name === 'Register')) next({ name: 'Dashboard' }) 
    else next()
  })
export default router