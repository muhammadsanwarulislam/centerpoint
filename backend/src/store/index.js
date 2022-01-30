import { createStore } from 'vuex'
import axiosClient from '../axios';

const store = createStore({

    state: {

        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN")
        },
    },

    getters: {},

    actions: {
        register({ commit }, user) {
            return axiosClient.post('/register', user)
                .then(({ data }) => {
                    commit('setUser', data)
                    return data
                })
        },

        login({ commit }, user) {
            return axiosClient.post('/login', user)
                .then(({ data }) => {
                    commit('setUser', data)
                    return data
                })
        },

        logout({ commit }) {
            return axiosClient.post('/logout')
                .then(response =>{
                    commit('logout')
                    return response
                })
        }
    },

    mutations: {
        logout: (state) => {
            state.user.data = {}
            // state.user.token = null
            state.user.token = sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, userData) => {
            state.user.token = userData.token
            state.user.data  = userData.user
            sessionStorage.setItem('TOKEN', userData.data.access_token)
        }
    },

    modules: {}
})

export default store