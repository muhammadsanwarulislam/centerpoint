// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
	css: [
		'@/assets/css/tailwindcss.css',
		'@/assets/css/style.css',
		'notivue/notifications.css',
		'notivue/animations.css',
	],
	// script: [],
	modules: [
		'@nuxtjs/tailwindcss',
		'@pinia/nuxt',
		'@pinia-plugin-persistedstate/nuxt',
		'@nuxtjs/i18n',
		'nuxt-swiper',
		'notivue/nuxt',
	],
	i18n: {
		vueI18n: './i18n.config.ts',
	},
	runtimeConfig: {
		public: {
			// useRuntimeConfig().public.apiURL
			// clientURL: 'http://localhost:3000/',
			apiURL: process.env.NUXT_PUBLIC_API_URL,
			appMode: process.env.NUXT_PUBLIC_APP_MODE,
		}
	}
});
