<script setup>
</script>
<template>
  <header class="sticky top-0 z-20 border-b">
    <!-- Container of flex -->
    <div class="container flex h-16 items-center justify-between">
      <!-- page title -->
      <div class="flex items-center gap-3 p-2">
        <Icon name="uil:heart-alt" class="h-5 w-5"/>
        <NuxtLink class="text-md font-bold" to="/">Admin Dashboard</NuxtLink>
      </div>
      <!-- Right side of header -->
      <div class="flex items-center gap-3 pr-5">
        <!-- <Icon name="uil:sun" /> -->
        <ColorModeButton />
      </div>
    </div>
  </header>
</template>
