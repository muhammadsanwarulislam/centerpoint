<script setup>
import { Pagination, Navigation } from 'swiper/modules';

const user_data = storeUserData().user_data;
const { locale, t } = useI18n();
</script>

<template>
    <h1 class="text-2xl font-bold pb-3">{{ $t('System_Statistics') }}</h1>
</template>

<style></style>