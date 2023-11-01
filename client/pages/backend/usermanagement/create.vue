<template>
  <section class="grid gap-5 md:grid-cols-2">
    <div class="flex items-center justify-between">
      <div class="mb-4">
        <label for="email" class="mb-2 block text-sm font-bold text-gray-700">Email</label>
        <input
          type="email"
          id="email"
          v-model="registerData.email"
          class="w-full rounded border p-2 focus:border-blue-400 focus:outline-none"
          required
        />
      </div>
    </div>

    <div class="flex items-center justify-between">
      <div class="mb-4">
        <label for="email" class="mb-2 block text-sm font-bold text-gray-700">Email</label>
        <input
          type="email"
          id="email"
          v-model="registerData.email"
          class="w-full rounded border p-2 focus:border-blue-400 focus:outline-none"
          required
        />
      </div>
    </div>

    <div class="text-center">
      <button
        type="submit"
        class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none"
      >
        Register
      </button>
    </div>
  </section>
</template>

<script lang="ts" setup>
definePageMeta({
    middleware: "is-logged-in",
  });
</script>
