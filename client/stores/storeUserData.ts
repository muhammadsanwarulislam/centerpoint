export const storeUserData = defineStore({
    id: 'user-store',
    state: () => {
        return {
            user_data: [],
            lang: '',
            get_component: ''
        }
    },
    actions: {
        addUserData(user_data: any) {
            this.user_data = user_data.user
        },
        addLang(lang: string) {
            this.lang = lang
        },
        getComponent(get_component: string) {
            this.get_component =get_component
        }
    },
    persist: true,
})