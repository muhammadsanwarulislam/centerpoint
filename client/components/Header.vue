<script setup>
import ColorModeButton from '~/components/common/ColorModeButton.vue';
</script>
<template>
  <header class="sticky top-0 z-20 border-b bg-white backdrop-blur">
    <!-- Container of flex -->
    <div class="container flex h-16 items-center justify-between">
      <!-- page title -->
      <div class="flex items-center gap-3">
        <NuxtLink class="text-xl font-bold" to="/">Admin Dashboard</NuxtLink>
      </div>
      <!-- Right side of header -->
      <div class="flex items-center gap-5">
        <ColorModeButton />
      </div>
    </div>
  </header>
</template>
