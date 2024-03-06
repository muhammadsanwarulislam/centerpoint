<script setup>
import { computed, onMounted, onUnmounted, watch } from "vue";

const props = defineProps({
	show: {
		type: Boolean,
		default: false,
	},
	maxWidth: {
		type: String,
		default: "2xl",
	},
	closeable: {
		type: Boolean,
		default: true,
	},
	apiData: Object,
});

// Create a reactive copy of the user data to edit
const editedUserData = ref({ ...props.apiData });
console.log(editedUserData);


// Method to close the modal
const closeModal = () => {
	// Emit the close event to parent component
	emit("close");
};

const emit = defineEmits(["close"]);

watch(
	() => props.show,
	() => {
		if (props.show) {
			document.body.style.overflow = "hidden";
		} else {
			document.body.style.overflow = null;
		}
	}
);

const close = () => {
	if (props.closeable) {
		emit("close");
	}
};

const closeOnEscape = (e) => {
	if (e.key === "Escape" && props.show) {
		close();
	}
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
	document.removeEventListener("keydown", closeOnEscape);
	document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
	return {
		sm: "sm:max-w-sm",
		md: "sm:max-w-md",
		lg: "sm:max-w-lg",
		xl: "sm:max-w-xl",
		"2xl": "sm:max-w-2xl",
	}[props.maxWidth];
});
</script>

<template>
	<teleport to="body">
		<transition leave-active-class="duration-200">
			<div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" scroll-region>
				<transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
					enter-to-class="opacity-100" leave-active-class="ease-in duration-200"
					leave-from-class="opacity-100" leave-to-class="opacity-0">
					<div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
						<div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75" />
					</div>
				</transition>

				<transition enter-active-class="ease-out duration-300"
					enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
					enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
					leave-from-class="opacity-100 translate-y-0 sm:scale-100"
					leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
					<div v-show="show"
						class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
						:class="maxWidthClass">
						<form class="p-4 md:p-5">
							<div class="grid gap-4 mb-4 grid-cols-2">
								<div class="col-span-2">
									<label for="name"
										class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
										Name</label>
									<input type="text" name="first_name" id="first_name"
										v-model="apiData.data.profile.first_name"
										class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
										placeholder="First Name" required="">
								</div>
								<div class="col-span-2">
									<label for="name"
										class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
										Name</label>
									<input type="text" name="first_name" id="first_name"
										v-model="apiData.data.profile.last_name"
										class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
										placeholder="Last Name" required="">
								</div>
								<div class="col-span-2 sm:col-span-1">
									<label for="gender"
										class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
									<input type="text" name="gender" id="gender" v-model="apiData.data.profile.gender"
										class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
										placeholder="Gender" required="">
								</div>
								<div class="col-span-2 sm:col-span-1">
									<label for="religion"
										class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">religion</label>
									<input type="text" name="religion" id="religion" v-model="apiData.data.profile.religion"
										class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
										placeholder="Religion" required="">
								</div>
								<div class="col-span-2">
									<label for="description"
										class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
										Date Of Birth</label>
									<input id="dob" type="date" v-model="apiData.data.profile.dob"
										class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
										placeholder="Write product description here">
								</div>
							</div>
							<button type="submit"
								class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
								<svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
									xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd"
										d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
										clip-rule="evenodd"></path>
								</svg>
								Update Profile
							</button>
						</form>
						<slot v-if="show" />
					</div>
				</transition>
			</div>
		</transition>
	</teleport>
</template>
