/** @type {import('tailwindcss').Config} */
import forms from '@tailwindcss/forms';
export default {
	content: [
		'./components/**/*.{js,vue,ts}',
		'./layouts/**/*.vue',
		'./pages/**/*.vue',
		'./plugins/**/*.{js,ts}',
		'./nuxt.config.{js,ts}',
		'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx,vue}',
    	'node_modules/flowbite/**/*.{js,jsx,ts,tsx}',
	],
	theme: {
		extend: {}
	},
	plugins: [
		forms,
		require('flowbite/plugin')
	]
};
