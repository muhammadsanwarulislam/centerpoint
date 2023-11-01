import type { User } from "~/types/users";
import type { Login } from "~/types/login";
import type { Register } from "~/types/register";

export const useAuthStore = defineStore("user", () => {
  const Base_URL = "http://127.0.0.1:8000";
  const user = ref();
  const token = useCookie("ACCESS_TOKEN", {
    maxAge: 60 * 60,
  });
  const permissions = ref<string[]>([]);
  const headers = {
    Authorization: `Bearer ${token.value}`,
    "Content-Type": "application/json",
  };

  const setToken = (data?: string) => {
    const userTokenJSON = JSON.stringify(data);
    sessionStorage.setItem("token", userTokenJSON);
    token.value = data;
  };

  const setUser = (data?: any) => {
    user.value = data;
    const userDataJSON = JSON.stringify(data);
    sessionStorage.setItem("userData", userDataJSON);
  };

  const setPermissions = (data?: string[]) => {
    permissions.value = data || [];
    const permissionsDataJSON = JSON.stringify(data || []);
    sessionStorage.setItem("userPermisions", permissionsDataJSON);
  };

  const setHeaders = () => {
    headers.Authorization = `Bearer ${token.value}`;
  };

  const signIn = async (data: Login) => {
    try {
      const res = await $fetch<User>(`${Base_URL}/api/login`, {
        method: "POST",
        body: data,
      });

      setToken(res.data.access_token);
      setUser(res.data.user);
      setHeaders();

      await fetchLoggedInUserPermissions();
    } catch (error) {
      setToken();
      setUser();
      console.log(error);
    }
  };

  const fetchLoggedInUserPermissions = async () => {
    if (token.value) {
      try {
        const res = await $fetch<User>(`${Base_URL}/api/logged-in-user-permission`, {
          method: "GET",
          headers: headers,
        });
        setPermissions(res.data.permissions.map((permission: { name: any }) => permission.name));
      } catch (error) {
        console.log(error);
      }
    }
  };

  const signUp = async (data: Register) => {
    try {
      const res = await $fetch<User>(`${Base_URL}/api/register`, {
        method: "POST",
        body: data,
      });
    } catch (error) {
      console.log(error);
    }
  };

  const logout = () => {
    setUser();
    setToken();
  };

  return {
    user,
    token,
    headers,
    signIn,
    signUp,
    logout,
    fetchLoggedInUserPermissions,
    permissions,
  };
});
