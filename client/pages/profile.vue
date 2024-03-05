<script setup>
definePageMeta({ middleware: ['auth'] });
useHead({
	title: 'Profile',
	description: 'See all available authentication & session information below.'
});
const { user } = useAuth();
const status = computed(() => {
	if (user.value) {
		return 'authenticated';
	}
	return 'unauthenticated';
});

</script>
<template>
	<div>
		<TopMenu :title="title = 'profile'" />
		<div class="p-4 sm:ml-64 dashboard_close">
			<div class="p-4 rounded-lg dark:border-gray-700">
				<h3 class="text-xl font-bold">Authentication Overview</h3>
				<p class="text-sm mb-4">See all available authentication & session information below.</p>
				<pre class="pre-auth" v-if="status"><span>Status:</span> {{ status }}</pre>
				<AuthenticationStatus />
				<pre class="pre-auth" v-if="user"><span>Data:</span> {{ user }}</pre>
			</div>
		</div>
	</div>
</template>
<style></style>
