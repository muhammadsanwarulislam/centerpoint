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

const menus = storeUserData().user_data.user.menus
</script>

<template>
    <div>
        <!-- Left Side Start -->
        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 sidebar"
            aria-label="Sidebar">
            <div class="h-full px-3 pb-4 pt-4 overflow-y-auto bg-white dark:bg-gray-800">
                <a href="/" class="flex items-center ps-2.5 mb-5">
                    <!-- <img src="/img/logo/emasbd-logo.png" class="h-8 sm:h-10" alt="emasbd Logo" /> -->
                    <svg width="196" height="55" viewBox="0 0 196 55" fill="none" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="196" height="55" fill="url(#pattern0)" />
                        <defs>
                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_2_7" transform="matrix(0.00358423 0 0 0.0127729 0 -0.00452916)" />
                            </pattern>
                            <image id="image0_2_7" width="279" height="79"
                                xlink:href="data:image/png;base64,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" />
                        </defs>
                    </svg>
                    <!-- <img :src="user_data?.user.image" class="h-6 me-3 sm:h-7" alt="emasbd Logo" /> -->
                    <!-- <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">emasbd</span> -->
                </a>
                <ul class="space-y-2 font-medium">
                    <!-- <li>
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
                    </li> -->

                    <!-- <li>
                        <a @click="loadComponent('School')"
                            :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'School' }"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 18">
                                <path
                                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">School</span>
                            <span
                                class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                        </a>
                    </li>
                    <li>
                        <a @click="loadComponent('Payment')"
                            :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'Payment' }"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Payment</span>
                            <span
                                class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
                        </a>
                    </li>
                    <li>
                        <a @click="loadComponent('Report')"
                            :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'Report' }"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 18">
                                <path
                                    d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Report</span>
                        </a>
                    </li>
                    <li>
                        <a @click="loadComponent('AttendanceDevice')"
                            :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == 'AttendanceDevice' }"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 20">
                                <path
                                    d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Attendance Device</span>
                        </a>
                    </li> -->
                    
                    <!-- <li>
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
                    </li> -->
                    
                    <li v-for="(item, index) in menus" :key="index">
                        <!-- if item.component not null then add @click -->
                        <button type="button"
                            @click="item.component ? loadComponent(item.component) : ''"
                            :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == item.component }"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            :aria-controls="'dropdown-example'+index" :data-collapse-toggle="'dropdown-example'+index">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 21">
                                <path
                                    d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{item.name}}</span>
                            <!-- if item.menu_items then show svg  -->
                            <svg v-if="item.menu_items.length > 0"
                            class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul :id="'dropdown-example'+index" class="hidden py-2 space-y-2">
                            <li v-for="submenus in item.menu_items" :key="submenus.id">
                                <a @click="loadComponent(submenus.component)"
                                    :class="{ 'bg-gray-100 dark:bg-gray-700': component_id == submenus.component }"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{submenus.name}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <!-- Left Side End -->
    </div>
</template>

<style></style>