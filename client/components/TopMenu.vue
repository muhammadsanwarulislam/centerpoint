<script setup>
// Get Data from store
const state_user_data = storeUserData()
const user_data = state_user_data.user_data;
const { addLang } = state_user_data

// Get Data Auth user
const { user = {}, logout } = useAuth();

// Change Language
const { locale, t } = useI18n();
const state = storeUserData()

const selected_lang = ref(state.lang ? state.lang : 'en')
locale.value = selected_lang.value

function changeLanguage() {
	addLang(selected_lang.value)
	locale.value = selected_lang.value
}

// Toggle Language
function ToggleChangeLanguage() {
	if (selected_lang.value === 'en') {
		selected_lang.value = 'bn'
	} else {
		selected_lang.value = 'en'
	}
	changeLanguage()
}

// closeSidebar make toggle button
const sidebarToggler = ref(false)

function closeSidebar() {
    const sidebar = document.querySelector('.sidebar')
    const dashboard_body = document.querySelector('.dashboard_close')
    sidebar.classList.toggle('closed')
    dashboard_body.classList.toggle('sm:ml-64')
    sidebarToggler.value = !sidebarToggler.value
}

const props = defineProps({
    title: {
        type: String,
        // default: 'dashboard'
    }
})
</script>

<template>
    <div>
        <!-- Top Menu Start-->
        <div class="px-3 py-3 lg:px-5 lg:pl-3 bg-white dark:bg-gray-800 top_menu" 
            :class="{
            'dashboard': props.title === 'dashboard' && !sidebarToggler,
            'innerPage': props.title !== 'dashboard' || (props.title === 'dashboard' && sidebarToggler)
            }"
        >
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end select-none">
                    <button v-if="props.title == 'dashboard'" data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                        type="button"
                        class="drawer_button inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>

                    <button v-if="props.title == 'dashboard'" @click="closeSidebar" class="desktop_view">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>

                    <a :href="'/' + props.title" class="topbar_title flex ms-2 md:me-24 select-none">
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white select-none">
                            {{$t(props.title)}}
                        </span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div class="flex items-center justify-center">
                            <label class="toggle mr-3">
                                <input type="checkbox" :checked="selected_lang === 'en' ? true : false"
                                    @click="ToggleChangeLanguage()">
                                <span class="slider"></span>
                                <span class="labels" :data-on="selected_lang === 'bn' ? 'bn' : 'BN'"
                                    :data-off="selected_lang === 'en' ? 'en' : 'EN'"></span>
                                <!-- <span class="labels" :data-on="selected_lang" :data-off="selected_lang"></span> -->
                            </label>

                            <!-- {{ state.lang }} -->
                            <!-- <form class="flex items-center justify-center pr-3">
									<select v-model="selected_lang" @change="changeLanguage">
										<option value="en">en</option>
										<option value="bn">bn</option>
									</select>
								</form> -->
                        </div>
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" :src="user_data?.user?.image" alt="user photo">
                            </button>
                        </div>

                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    {{ user_data?.user.username }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ user_data?.user.email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="/profile"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Profile</a>
                                </li>
                                <li>
                                    <a href="/dashboard"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#" @click="logout"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Menu End-->
    </div>
</template>

<style></style>