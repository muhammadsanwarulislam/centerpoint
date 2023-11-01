<script setup lang="ts"></script>
<template>
  <div>
    <!-- Header -->
    <Header />
    <div class="container lg:grid lg:grid-cols-12 lg:gap-10">
      <!-- Sidebar -->
      <Sidebar class="hidden lg:col-span-3 lg:block" />
      <!-- Main Section -->
      <main class="py-5 lg:col-span-6">
        <slot />
      </main>
    </div>
  </div>
</template>
