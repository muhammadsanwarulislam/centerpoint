<script setup>
// Load Dynamic Component
const { getComponent } = storeUserData()
function loadComponent(component) {
    getComponent(component)
}

const component_id = ref(storeUserData().get_component || 'Overview')
watch(() => storeUserData().get_component, (value) => {
    component_id.value = value
})
</script>

<template>
    <div>
        <!-- Left Side Start -->
        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 sidebar"
            aria-label="Sidebar">
            <div class="h-full px-3 pb-4 pt-4 overflow-y-auto bg-white dark:bg-gray-800">
                <a href="/" class="flex items-center ps-2.5 mb-5">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="emasbd Logo" />
                    <!-- <img :src="user_data?.user.image" class="h-6 me-3 sm:h-7" alt="emasbd Logo" /> -->
                    <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">centerpoint</span>
                </a>
                <ClientOnly>
                    <ul class="space-y-2 font-medium">
                        <li>
                            <a @click="loadComponent('Overview')"
                                :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'Overview' }"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 22 21">
                                    <path
                                        d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                    <path
                                        d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                                </svg>
                                <span class="ms-3">Overview</span>
                            </a>
                        </li>
                        <li>
                            <a @click="loadComponent('UserCreation')"
                                :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'UserCreation' }"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 20">
                                    <path
                                        d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">User Creation</span>
                            </a>
                        </li>
                        <li>
                            <a @click="loadComponent('RoleCreation')"
                                :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'RoleCreation' }"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 20">
                                    <path
                                        d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Role Creation</span>
                            </a>
                        </li>
                        <li>
                            <a @click="loadComponent('PermissionCreation')"
                                :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'PermissionCreation' }"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 18 20">
                                    <path
                                        d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Permission Creation</span>
                            </a>
                        </li>
                    </ul>
                </ClientOnly>
            </div>
        </aside>
        <!-- Left Side End -->
    </div>
</template>

<style></style>