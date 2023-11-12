<script setup>
import { useAuthStore } from "../stores/auth";
definePageMeta({
  middleware: "is-logged-in",
  layout: "frontend",
});
const userStore = useAuthStore();
const email = ref(null);
const password = ref(null);

const singIn = async () => {
  await userStore.signIn({
    email: email.value,
    password: password.value,
  });
  return navigateTo("/");
};
</script>
<template>
  <div class="container mx-auto p-4">
    <div class="mx-auto max-w-md">
      <form @submit.prevent="singIn">
        <div class="mb-4">
          <label for="email" class="mb-2 block text-sm font-bold text-gray-700">Email</label>
          <input type="email" id="email" v-model="email"
            class="w-full rounded border p-2 focus:border-blue-400 focus:outline-none" required />
        </div>
        <div class="mb-4">
          <label for="password" class="mb-2 block text-sm font-bold text-gray-700">Password</label>
          <input type="password" id="password" v-model="password"
            class="w-full rounded border p-2 focus:border-blue-400 focus:outline-none" required />
        </div>
        <div class="text-center">
          <button type="submit" class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

