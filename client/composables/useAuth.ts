export type User = {
	name?: string;
	email?: string;
	image?: string;
};

export type LoginCredentials = {
	email: string;
	password: string;
};

export type RegisterCredentials = {
	name: string;
	email: string;
	password: string;
	password_confirmation: string;
};

export type ResetPasswordCredentials = {
	email: string;
	password: string;
	password_confirmation: string;
	token: string;
};

// api endpoint
const LOGIN = '/login';
const REGISTER = '/register';
const LOGOUT = '/logout';
const FORGOT_PASSWORD = '/forgot-password';
const RESET_PASSWORD = '/auth/reset-password';
const CURRENT_USER = '/current-user';
const EMAIL_VERIFICATION = '/email/verification-notification';

// Value is initialized in: ~/plugins/auth.ts
export const useUser = () => {
	return useState<User | undefined | null>('user', () => undefined);
};

export const useAuth = () => {
	const router = useRouter();

	const user = useUser();
	const isLoggedIn = computed(() => !!user.value);
	const cookie = useCookie($X_TOKEN);

	async function refresh() {
		try {
			user.value = await fetchCurrentUser();
		} catch {
			user.value = null;
		}
	}

	async function login(credentials: LoginCredentials) {
		if (isLoggedIn.value) return;

		const response: any = await $http(LOGIN, { method: 'post', body: credentials });
		cookie.value = response.data?.access_token; // set cookie
		return response;
	}

	async function register(credentials: RegisterCredentials) {
		const response: any = await $http(REGISTER, { method: 'post', body: credentials });
		cookie.value = response.token; // set cookie
		return response;
	}

	async function resendEmailVerification() {
		return await $http<{ status: string }>(EMAIL_VERIFICATION, { method: 'post' });
	}

	async function logout() {
		if (!isLoggedIn.value) return;
		
		// Delete cookie
		document.cookie = `user-store=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
		user.value = null;
		cookie.value = null;
		// window.location.reload();
		router.push('/login');
		storeUserData().get_component = ''
		// await $http(LOGOUT);
	}

	async function forgotPassword(email: string) {
		return await $http(FORGOT_PASSWORD, {
			method: 'post',
			body: { email }
		});
	}

	async function resetPassword(credentials: ResetPasswordCredentials) {
		return await $http(RESET_PASSWORD, {
			method: 'post',
			body: credentials
		});
	}

	return {
		user,
		isLoggedIn,
		login,
		register,
		resendEmailVerification,
		logout,
		forgotPassword,
		resetPassword,
		refresh
	};
};

export const fetchCurrentUser = async () => {
	try {
		return await $http<User>(CURRENT_USER, {
			redirectIfNotAuthenticated: false
		});
	} catch (error: any) {
		if ([401, 400, 419].includes(error?.response?.status)) return null;
		console.error(error);
	}
};
