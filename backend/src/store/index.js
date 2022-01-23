import { createStore } from 'vuex'

const store = createStore({

    state: {

        user: {
            data: {
                name: "Tom Cook",
                email: "tom@example.com",
                imageUrl:"https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            },
            token: 222
        },
    },

    getters: {},

    mutations: {
        logout: (state) => {
            state.user.data = {}
            state.user.token = null
        },
    },

    actions: {},

    modules: {}
})

export default store