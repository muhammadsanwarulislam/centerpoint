import { useAuthStore } from "./auth";
import type { User } from "~/types/users";

export const useUserManagementStore = defineStore("userManagement", () => {
  const Base_URL = "http://127.0.0.1:8000";
  const users = ref<string[]>([]);
  const authStore = useAuthStore();
  const headers = authStore.headers;

  const setUsers = (data?: string[]) => {
    users.value = data || [];
  };

  const userList = async () => {
    try {
      const res = await $fetch<User>(`${Base_URL}/api/users`, {
        method: "GET",
        headers: headers,
      });

      // setUsers(res.data.users.map((users: { name: any }) => users));
    } catch (error) {
      console.log(error);
    }
  };

  return {
    userList,
    setUsers,
  };
});
