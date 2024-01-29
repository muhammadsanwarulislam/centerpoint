<script setup>
import { Pagination, Navigation } from 'swiper/modules';

const user_data = storeUserData().user_data;
const { locale, t } = useI18n();
</script>

<template>
    <!-- <h1 class="text-2xl font-bold pb-2">{{ user_data?.user['title_' + locale] }}</h1> -->
    <h1 class="text-2xl font-bold pb-3">{{ $t('System_Statistics') }}</h1>
    <div>
        <div class="flex flex-wrap">
            <div class="w-full sm:w-1/2 lg:w-1/4 pr-3 pb-3">
                <a href="#"
                    class="block max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $t('School_Connected') }}
                    </h5>
                    <div class="flex justify-between items-center py-2">
                        <p class="text-4xl font-bold"> 63 </p>
                        <span>icon</span>
                    </div>
                    <p>15% decreased than last month</p>
                </a>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/4 pr-3 pb-3">
                <a href="#"
                    class="block max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $t('Collection') }}
                    </h5>
                    <div class="flex justify-between items-center py-2">
                        <p class="text-4xl font-bold"> 15,900 </p>
                        <span>icon</span>
                    </div>
                    <p>15% decreased than last month</p>
                </a>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/4 pr-3 pb-3">
                <a href="#"
                    class="block max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $t('Due') }}
                    </h5>
                    <div class="flex justify-between items-center py-2">
                        <p class="text-4xl font-bold"> 12,080 </p>
                        <span>icon</span>
                    </div>
                    <span class="underline"> View list </span>
                </a>
            </div>
            <div class="w-full sm:w-1/2 lg:w-1/4 pr-3 pb-3">
                <a href="#"
                    class="block max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $t('SMS_Left') }}
                    </h5>
                    <div class="flex justify-between items-center py-2">
                        <p class="text-4xl font-bold"> 1.3k </p>
                        <span>icon</span>
                    </div>
                    <span class="underline">Show details</span>
                </a>
            </div>
        </div>
    </div>
    <div>
        <h1 class="text-2xl font-bold pb-3 pt-4">{{ $t('Recent_Connection') }}</h1>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="bg-white">
                        <th scope="col" class="px-2 py-4 text-center">
                            #
                        </th>
                        <th scope="col" class="px-4 py-4">
                            School
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            Joining
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            Student
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            Package
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            Amount
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            SMS
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in 4"
                        class="even:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-2 py-4 text-center">
                            {{ item }}
                        </td>
                        <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Dhaka Residential Model College
                        </th>
                        <td class="px-4 py-4 text-center text-gray-900">
                            July 17, 2023
                        </td>
                        <td class="px-4 py-4 text-center text-gray-900">
                            12244
                        </td>
                        <td class="px-4 py-4 text-center text-gray-900">
                            7
                        </td>
                        <td class="px-4 py-4 text-center text-gray-900">
                            $2999
                        </td>
                        <td class="px-4 py-4 text-center text-gray-900">
                            29
                        </td>
                        <td class="px-4 py-4 text-center text-gray-900">
                            999
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <h1 class="text-2xl font-bold pb-6 pt-8">{{ $t('Sales_Operation_This_Month') }}</h1>
        <div>
            <swiper
                :slidesPerView="1"
                :spaceBetween="10"
                :pagination="{
                    clickable: true,
                }"
                :breakpoints="{
                    '640': {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    '768': {
                        slidesPerView: 2,
                        spaceBetween: 40,
                    },
                    '1024': {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                    '1400': {
                        slidesPerView: 4,
                        spaceBetween: 40,
                    },
                    '1600': {
                        slidesPerView: 5,
                        spaceBetween: 50,
                    },
                }"
                :creative-effect="{
                    prev: {
                        shadow: false,
                        translate: ['-20%', 0, -1],
                    },
                    next: {
                        translate: ['100%', 0, 0],
                    },
                }"
                :loop="true"
                :effect="'creative'"
                :autoplay="{
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                }"
                :modules="[SwiperAutoplay, Pagination, Navigation]"
                class="mySwiper"
            >
                <swiper-slide v-for="item in 10">
                    <div class="card">
                        <img :src="user_data?.user.image" alt="image">
                        <div class="card-body">
                            <h3 class="px-2 py-2 font-medium text-gray-900 w-full text-center whitespace-nowrap dark:text-white truncate">{{ user_data?.user.name }}</h3>
                            <p class="text-gray-900 w-full text-center truncate">Software Engineer</p>
                            <p class="text-gray-900 w-full text-center truncate">01977879681</p>
                        </div>
                        <div class="card-bottom">
                            <p class="font-medium text-gray-900 w-full text-center whitespace-nowrap dark:text-white truncate">8 School This Month</p>
                            <p class="text-gray-900 w-full text-center truncate">Collection: 18,100 BDT.</p>
                            <p class="text-gray-900 w-full text-center truncate text-green-600">8% Rate Increased</p>
                        </div>
                    </div>
                </swiper-slide>
            </swiper>
        </div>
    </div>
    <div>
        <h1 class="text-2xl font-bold pb-6 pt-8">{{ $t('Agent_Operation') }}</h1>
        <div>
            <swiper
                :slidesPerView="1"
                :spaceBetween="10"
                :pagination="{
                    clickable: true,
                }"
                :breakpoints="{
                    '640': {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    '768': {
                        slidesPerView: 1,
                        spaceBetween: 40,
                    },
                    '1200': {
                        slidesPerView: 2,
                        spaceBetween: 40,
                    },
                    '1400': {
                        slidesPerView: 2,
                        spaceBetween: 40,
                    },
                    '1600': {
                        slidesPerView: 3,
                        spaceBetween: 50,
                    },
                }"
                :creative-effect="{
                    prev: {
                        shadow: false,
                        translate: ['-20%', 0, -1],
                    },
                    next: {
                        translate: ['100%', 0, 0],
                    },
                }"
                :loop="true"
                :effect="'creative'"
                :autoplay="{
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                }"
                :modules="[SwiperAutoplay, Pagination, Navigation]"
                class="mySwiper"
            >
                <swiper-slide v-for="item in 10">
                    <div class="agent_card">
                        <div class="card-body">
                            <div class="left-item">
                                <img :src="user_data?.user.image" alt="agent_card_logo">
                                <div class="px-3">
                                    <h3 class="font-medium text-gray-900 w-full text-left whitespace-nowrap dark:text-white truncate">{{ user_data?.user.name }}</h3>
                                    <p class="text-gray-900 w-full text-left truncate">Mirpur, Dhaka</p>
                                    <p class="text-gray-900 w-full text-left truncate">20 March 2023</p>
                                </div>
                            </div>
                            <div class="label">
                                <span class="icon active"></span>
                                <span>Active</span>
                            </div>
                        </div>
                        <div class="card-bottom">
                            <div>
                                <p class="text-4xl text-center font-bold">12</p>
                                <p class="text-gray-900 text-center">Total School</p>
                            </div>
                            <div>
                                <p class="text-4xl text-center font-bold">4</p>
                                <p class="text-gray-900 text-center">This Month</p>
                            </div>
                            <div>
                                <p class="text-4xl text-center font-bold">14790</p>
                                <p class="text-gray-900 text-center">Running Collection </p>
                            </div>
                        </div>
                    </div>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>

<style></style>