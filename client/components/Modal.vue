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
  method: {
    type: String,
    default: "",
  },
  apiData: Object,
  formFields: Array,
});

const closeModal = () => emit("close");
const emit = defineEmits(["close"]);

const form = ref({});
const apiEndpoint = computed(() =>
  props.apiData && props.apiData.user_id
    ? `/users/${props.apiData.user_id}`
    : null
);

const initializedForm = computed(() => ({ ...props.apiData }));
watch(initializedForm, (newValue) => Object.assign(form.value, newValue), {
  immediate: true,
});

const close = () => {
  if (props.closeable) emit("close");
};
const closeOnEscape = (e) => {
  if (e.key === "Escape" && props.show) close();
};
onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => {
  document.removeEventListener("keydown", closeOnEscape);
  document.body.style.overflow = null;
});

const maxWidthClass = computed(
  () =>
    ({
      sm: "sm:max-w-sm",
      md: "sm:max-w-md",
      lg: "sm:max-w-lg",
      xl: "sm:max-w-xl",
      "2xl": "sm:max-w-2xl",
    }[props.maxWidth])
);

const submitForm = async () => {
  try {
    console.log(props.method);
    const response = await $http(apiEndpoint.value, {
      method: props.method,
      body: form.value,
    });
    push.success(response.message);
    closeModal();
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <teleport to="body">
    <transition leave-active-class="duration-200">
      <div
        v-show="show"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
        scroll-region
      >
        <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div
            v-show="show"
            class="fixed inset-0 transform transition-all"
            @click="close"
          >
            <div
              class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"
            />
          </div>
        </transition>

        <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            v-show="show"
            class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
            :class="maxWidthClass"
          >
            <form @submit.prevent="submitForm" class="p-4 md:p-5">
              <div class="grid gap-4 mb-4 grid-cols-2">
                <template v-for="(field, index) in formFields" :key="index">
                  <div class="col-span-1">
                    <label
                      :for="field.name"
                      class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                      >{{ field.label }}</label
                    >
                    <input
                      :type="field.type"
                      :id="field.name"
                      v-model="form[field.name]"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    />
                  </div>
                </template>
              </div>
              <div class="flex items-center gap-4">
                <button
                  type="submit"
                  class="py-2 px-4 bg-blue-500 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 hover:bg-blue-600"
                >
                  Save
                </button>
                <transition
                  enter-from-class="opacity-0"
                  leave-to-class="opacity-0"
                  class="transition ease-in-out"
                >
                  <p
                    v-if="form.recentlySuccessful"
                    class="text-sm text-gray-600 dark:text-gray-400"
                  >
                    Saved.
                  </p>
                </transition>
              </div>
            </form>
            <slot v-if="show" />
          </div>
        </transition>
      </div>
    </transition>
  </teleport>
</template>
