import { useAuthStore } from "~/stores/auth";

export default defineNuxtRouteMiddleware((to, from) => {
  const userStore = useAuthStore();

  if (!userStore.token) {
    return navigateTo("/login");
  }
});
