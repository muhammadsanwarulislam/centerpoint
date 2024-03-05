<script setup>
	// Get Data from state
	const state_user_data = storeUserData()
	const { user, logout } = useAuth();
	const status = computed(() => {
		if (user.value) {
			return 'authenticated';
		}
		return 'unauthenticated';
	});
</script>


<template>
	<div class="bg-white px-5 py-4 rounded-t shadow-xl">
		<div class="flex items-center justify-between">
			<div class="flex items-center space-x-2">
				<h1 v-if="status === 'authenticated'" class="text-lg">Authenticated as {{ state_user_data.user_data?.username }},</h1>
				<h1 v-if="status === 'authenticated'" class="text-lg"> email: {{ state_user_data.user_data?.email }}!</h1>
				<h1 v-else>Not logged in</h1>
			</div>
		</div>
	</div>
</template>