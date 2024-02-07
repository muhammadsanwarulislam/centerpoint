<template>
	<div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
		<Notivue v-slot="item">
			<Notifications :item="item" />
		</Notivue>
		<slot />
	</div>
</template>