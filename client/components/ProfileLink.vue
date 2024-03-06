<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['open-modal']);

const openModal = () => {
  emit('open-modal');
};
</script>

<template>
    <li>
      <a
        href="#"
        @click="openModal"
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
        role="menuitem"
      >
        Profile
      </a>
    </li>
  </template>

  