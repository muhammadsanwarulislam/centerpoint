<script setup>
useHead({ title: 'Login' });
definePageMeta({ middleware: ['guest'], layout: 'guest' });

const { user } = useAuth();
if (user.value) {
	window.location.href = '/dashboard';
}

const form = reactive({
	email: 'super@gmail.com',
	password: 'password',
	remember: false
});
const unauthorizedError = ref('');

const { login } = useAuth();
const {
	submit,
	isLoading,
	validationErrors: errors
} = useSubmit(() => login(form), {
	onSuccess: (response) => {
		console.log('response', response.data);
		// store user data into state
		storeUserData().addUserData(response.data);
		window.location.href = '/dashboard';
	},
	onError: (error) => {
		console.log(error.data);
		unauthorizedError.value = error.data.message;
	}
});

</script>

<template>
	<ClientOnly>
		<AuthCard>
			<template #logo>
				<NuxtLink to="/">
					<ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
				</NuxtLink>
			</template>
			<form @submit.prevent="submit">
				<div>
					<InputLabel for="email" value="Email" />
	
					<TextInput id="email" type="text" class="mt-1 block w-full" v-model="form.email" required autofocus
						autocomplete="email" />
	
					<InputError class="mt-2" :message="unauthorizedError" />
				</div>
	
				<div class="mt-4">
					<InputLabel for="password" value="Password" />
	
					<TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
						autocomplete="current-password" />
				</div>
	
				<div class="block mt-4">
					<label class="flex items-center">
						<Checkbox name="remember" v-model:checked="form.remember" />
						<span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
					</label>
				</div>
	
				<div class="flex items-center justify-end mt-4">
					<NuxtLink href="/forgot-password"
						class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
						Forgot your password?
					</NuxtLink>
	
					<PrimaryButton class="ml-4" :class="{ 'opacity-25': isLoading }" :disabled="isLoading">
						Log in
					</PrimaryButton>
				</div>
			</form>
		</AuthCard>
	</ClientOnly>
</template>