<script setup>
import { useAuthStore } from "../stores/auth";
definePageMeta({
  middleware: "is-logged-in",
  layout: "frontend",
});
const userStore = useAuthStore();
const name = ref(null);
const email = ref(null);
const password = ref(null);
const password_confirmation = ref(null);

const signUp = async () => {
  await userStore.signUp({
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
  });
  return navigateTo("/login");
};
</script>

<template>
  <div class="container mx-auto p-4">
    <div class="mx-auto max-w-md">
      <form @submit.prevent="signUp">
        <div class="mb-4">
          <label for="name" class="mb-2 block text-sm font-bold text-gray-700">Name</label>
          <input type="text" id="name" v-model="name"
            class="w-full rounded border p-2 focus:border-blue-400 focus:outline-none" required />
        </div>
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
        <div class="mb-4">
          <label for="password_confirmation" class="mb-2 block text-sm font-bold text-gray-700">Password
            Confirmation</label>
          <input type="password" id="password_confirmation" v-model="password_confirmation"
            class="w-full rounded border p-2 focus:border-blue-400 focus:outline-none" required />
        </div>
        <div class="text-center">
          <button type="submit" class="rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none">
            signUp
          </button>
        </div>
      </form>
    </div>
  </div>
</template>


