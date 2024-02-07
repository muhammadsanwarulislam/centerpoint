<template>
	<div>
		<slot name="logo" />
	</div>

	<div class="w-11/12 sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
		<slot />
	</div>
</template>