<script setup>
import ColorModeButton from '~/components/common/ColorModeButton.vue';
</script>
<template>
  <header class="sticky top-0 z-20 border-b bg-background/80 backdrop-blur">
    <!-- Container of flex -->
    <div class="container flex h-16 items-center justify-between">
      <!-- Logo and page title -->
      <div class="flex items-center gap-3">
        <!-- Logo -->
        <img
          src="https://img.logoipsum.com/296.svg"
          alt="Analytics logo"
          class="h-7 w-7 object-contain"
        />
        <!-- Page title -->
        <NuxtLink class="text-xl font-bold" to="/">Admin Dashboard</NuxtLink>
      </div>
      <!-- Right side of header -->
      <div class="flex items-center gap-5">
        <ColorModeButton />
      </div>
    </div>
  </header>
</template>
