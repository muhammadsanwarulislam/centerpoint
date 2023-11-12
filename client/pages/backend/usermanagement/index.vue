<script setup>
import { useUserManagementStore } from "../../../stores/userManagement";
const userManagementStore = useUserManagementStore();
const userList = ref([]);
console.log('sanwarul',userManagementStore.userList());
definePageMeta({
  middleware: "is-logged-in",
});
const items = [{
  label: 'List',
  icon: 'i-heroicons-llist-bullet-20-solid',
  content: 'This is the content shown for Tab1'
}, {
  label: 'Create',
  icon: 'i-heroicons-pluser-plus',
  content: 'And, this is the content for Tab2'
}]
</script>

<template>
  <UTabs :items="items" class="w-full">
    <template #default="{ item, index, selected }">
      <div class="flex items-center gap-2 relative truncate">
        <UIcon :name="item.icon" class="w-4 h-4 flex-shrink-0" />

        <span class="truncate">{{ index + 1 }}. {{ item.label }}</span>

        <span v-if="selected" class="absolute -right-4 w-2 h-2 rounded-full bg-primary-500 dark:bg-primary-400" />
      </div>
    </template>
  </UTabs>
</template>


