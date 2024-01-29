export const storeAppInfo = defineStore({
    id: 'appInfo-store',
    state: () => {
        return {
            domain: '',
        }
    },
    actions: {
        addDomain(domain: string) {
            this.domain = domain
        }
    },
    persist: true,
})