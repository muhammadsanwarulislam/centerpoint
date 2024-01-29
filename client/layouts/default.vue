<script setup>
import { initFlowbite } from 'flowbite';

// initialize components based on data attribute selectors
onMounted(() => {
	initFlowbite();
})

</script>

<template>
	<div class="min-h-screen bg-gray-50 white:bg-gray-900 mt-14">
		<!-- Page Content -->
		<main>
			<Notivue v-slot="item">
				<Notifications :item="item" />
			</Notivue>
			<slot />
		</main>
	</div>
</template>