<template>
  <div
    class="overflow-x-auto rounded-md border bg-background scrollbar-thin scrollbar-thumb-input scrollbar-thumb-rounded-md"
  >
    <table class="w-full border-collapse">
      <thead>
        <tr class="border-b text-left text-xs">
          <th class="p-4 font-medium uppercase text-muted-foreground">Product</th>
          <th class="p-4 font-medium uppercase text-muted-foreground">Payment</th>
          <th class="p-4 font-medium uppercase text-muted-foreground">Status</th>
          <th class="p-4 font-medium uppercase text-muted-foreground"></th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="n in 6"
          :key="n"
          class="border-b text-left text-sm last:border-b-0 hover:bg-muted"
        >
          <td class="p-4">Nike Shoes</td>
          <td class="p-4">Paid</td>
          <td class="p-4">Shipped</td>
          <td class="p-4">
            <div class="flex items-center gap-3">
              <button>
                <Icon name="heroicons:pencil" class="h-4 w-4 text-muted-foreground" />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts" setup>
definePageMeta({
    middleware: "is-logged-in",
  });
  import { useUserManagementStore } from "../../../stores/userManagement";
  const userManagementStore = useUserManagementStore();
  const userList = ref([]);
  console.log(userManagementStore.userList());
</script>
