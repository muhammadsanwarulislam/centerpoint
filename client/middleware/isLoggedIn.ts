import { useAuthStore } from "~/stores/auth";

export default defineNuxtRouteMiddleware((to, from) => {
  const authStore = useAuthStore();

  if (to.fullPath === "/login" && authStore.token) {
    return navigateTo("/");
  }

  if (to.fullPath === "/register" && authStore.token) {
    return navigateTo("/");
  }

  if (to.fullPath === "/" && !authStore.token) {
    return navigateTo("/login");
  }
});
