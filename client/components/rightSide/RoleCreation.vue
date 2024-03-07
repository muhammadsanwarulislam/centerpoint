<script setup>
import { ref, onMounted, watch } from "vue";
import { FwbButton, FwbModal, FwbPagination } from "flowbite-vue";

const role_list = ref([]);
const current_page = ref(1);
const total_page = ref(0);
const limit = ref(5);
const is_loading = ref(false);
const search_data = ref("");

const permission_list = ref([]);
const is_show_modal = ref(false);
const is_validation = ref(false);
const is_name_exist = ref("");
const role_id = ref(null);

const spinner = ref(false);
const form = ref({
  name: "",
  permissions: [],
});

async function getRoleList() {
  try {
    is_loading.value = true;
    const response = await $http(
      `/roles?&option=search&offset=${current_page.value}&limit=${limit.value}&searchData=${search_data.value}`,
      {
        method: "GET",
      }
    );

    role_list.value = response.data;
    total_page.value = Math.ceil(response.total / limit.value);
  } catch (error) {
    role_list.value = [];
  } finally {
    is_loading.value = false;
  }
}

async function getRoleByID(id) {
  try {
    const response = await $http(`/roles/${id}`, {
      method: "GET",
    });
    let data = response.data;
    form.value = {
      name: data.name,
      permissions: data.permissions.map((item) => item.id),
    };
    role_id.value = id;
  } catch (error) {
    console.log(error);
  }
}

async function getPermissionList() {
  try {
    const response = await $http(`/permissions`, {
      method: "GET",
    });
    permission_list.value = response.data;
  } catch (error) {
    console.log(error);
  }
}

async function deleteRole(id) {
  try {
    const response = await $http(`/roles/${id}`, {
      method: "DELETE",
      body: form.value,
    });

    const index = role_list.value.findIndex((item) => item.id === id);
    if (index !== -1) {
      role_list.value.splice(index, 1);
    }

    push.success(response.message);
  } catch (error) {
    console.log(error);
  }
}

onMounted(() => {
  getRoleList();
  getPermissionList();
});

watch([current_page, search_data], () => {
  getRoleList();
});

const isEditing = computed(() => !!role_id.value);

function closeModal() {
  is_show_modal.value = false;
  is_validation.value = false;
  form.value = {
    name: "",
    permissions: [],
  };
  role_id.value = null;
}

function showModal(id) {
  is_show_modal.value = true;
  if (id) {
    getRoleByID(id);
  }
}

async function createRole() {
  try {
    if (form.value.name === "") {
      is_validation.value = true;
      return;
    }
    spinner.value = true;
    const response = await $http(`/roles`, {
      method: "POST",
      body: form.value,
    });
    push.success(response.message);
    role_list.value.unshift(response.data.role);
    closeModal();
  } catch (error) {
    handleApiError(error);
  } finally {
    spinner.value = false;
  }
}

async function updateRoleByID(id) {
  try {
    if (form.value.name === "") {
      is_validation.value = true;
      return;
    }
    spinner.value = true;
    const response = await $http(`/roles/${id}`, {
      method: "PUT",
      body: form.value,
    });

    const index = role_list.value.findIndex((item) => item.id === id);

    if (index !== -1) {
      role_list.value[index] = response.data.role;
    }

    push.success(response.message);
    closeModal();
  } catch (error) {
    handleApiError(error);
  } finally {
    spinner.value = false;
  }
}

function handleApiError(error) {
  console.log(error);

  const errors = error.data?.errors;
  const defaultMessage = error.data?.message;
  if (errors) {
    if (errors.name) {
      is_name_exist.value = errors.name[0];
    }
  } else {
    push.error(defaultMessage || "An unknown error occurred");
  }
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold pb-3">Role Creation</h1>
    <div class="flex flex-wrap gap-3 items-center justify-between pt-3 pb-5">
      <div class="bg-white xs:w-full sm:w-full md:w-2/5 lg:w-2/5 sm-w-100">
        <label
          for="default-search"
          class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
          >Search</label
        >
        <div class="relative">
          <div
            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
          >
            <svg
              class="w-4 h-4 text-gray-500 dark:text-gray-400"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 20 20"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
              />
            </svg>
          </div>
          <input
            v-model="search_data"
            v-on:keyup.enter="getRoleList"
            class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Type Role Name"
          />
        </div>
      </div>

      <div class="flex flex-wrap items-center justify-between gap-3">
        <button class="button btn" @click="showModal">+ Add Role</button>
      </div>
    </div>
    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-4">
      <table
        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
      >
        <thead
          class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
        >
          <tr class="bg-white">
            <th scope="col" class="px-2 py-4 text-center">#</th>
            <th scope="col" class="px-4 py-4 text-left">Role</th>
            <th scope="col" class="px-4 py-4 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-if="is_loading"
            class="bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 h-80"
          >
            <td colspan="3">
              <div class="flex justify-center">
                <div class="loader-three-dots"></div>
              </div>
            </td>
          </tr>
          <tr
            v-else-if="!is_loading && role_list.length === 0"
            class="bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 h-80"
          >
            <td colspan="3">
              <div class="flex justify-center">
                <p class="text-gray-500 dark:text-gray-400">No data found</p>
              </div>
            </td>
          </tr>
          <tr
            v-else
            v-for="(item, index) in role_list"
            :key="index"
            class="odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
          >
            <td class="px-2 py-4 text-center">
              {{ limit * (current_page - 1) + index + 1 }}
            </td>
            <th
              scope="row"
              class="px-4 py-4 text-left font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ item.name }}
            </th>
            <td class="px-4 py-4 text-center text-gray-900">
              <button class="mr-2 table-btn" @click="showModal(item.id)">
                <svg
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_41_2780)">
                    <path
                      d="M15.547 0.775162L5.38701 10.9352C4.99896 11.3211 4.69132 11.7802 4.48191 12.2859C4.2725 12.7915 4.16546 13.3337 4.16701 13.881V15.0002C4.16701 15.2212 4.25481 15.4331 4.41109 15.5894C4.56737 15.7457 4.77933 15.8335 5.00034 15.8335H6.11951C6.66681 15.835 7.20898 15.728 7.71464 15.5186C8.22029 15.3092 8.67939 15.0015 9.06534 14.6135L19.2253 4.4535C19.7123 3.9653 19.9858 3.30389 19.9858 2.61433C19.9858 1.92477 19.7123 1.26335 19.2253 0.775162C18.7301 0.30174 18.0713 0.0375366 17.3862 0.0375366C16.701 0.0375366 16.0423 0.30174 15.547 0.775162ZM18.047 3.27516L7.88701 13.4352C7.41711 13.9022 6.78201 14.1651 6.11951 14.1668H5.83368V13.881C5.83541 13.2185 6.09831 12.5834 6.56534 12.1135L16.7253 1.9535C16.9033 1.78346 17.14 1.68857 17.3862 1.68857C17.6323 1.68857 17.869 1.78346 18.047 1.9535C18.222 2.12892 18.3202 2.36657 18.3202 2.61433C18.3202 2.86209 18.222 3.09973 18.047 3.27516Z"
                      fill="#374957"
                    />
                    <path
                      d="M19.1667 7.48247C18.9457 7.48247 18.7337 7.57027 18.5774 7.72655C18.4211 7.88283 18.3333 8.09479 18.3333 8.3158V12.5H15C14.337 12.5 13.7011 12.7634 13.2322 13.2322C12.7634 13.701 12.5 14.3369 12.5 15V18.3333H4.16667C3.50363 18.3333 2.86774 18.0699 2.3989 17.6011C1.93006 17.1322 1.66667 16.4963 1.66667 15.8333V4.16664C1.66667 3.5036 1.93006 2.86771 2.3989 2.39887C2.86774 1.93003 3.50363 1.66664 4.16667 1.66664H11.7017C11.9227 1.66664 12.1346 1.57884 12.2909 1.42256C12.4472 1.26628 12.535 1.05432 12.535 0.833303C12.535 0.612289 12.4472 0.400328 12.2909 0.244047C12.1346 0.0877669 11.9227 -3.05176e-05 11.7017 -3.05176e-05L4.16667 -3.05176e-05C3.062 0.0012927 2.00297 0.440704 1.22185 1.22182C0.440735 2.00293 0.00132321 3.06197 0 4.16664L0 15.8333C0.00132321 16.938 0.440735 17.997 1.22185 18.7781C2.00297 19.5592 3.062 19.9986 4.16667 20H13.6192C14.1666 20.0015 14.7089 19.8945 15.2147 19.6851C15.7205 19.4757 16.1797 19.168 16.5658 18.78L18.7792 16.565C19.1673 16.179 19.475 15.72 19.6846 15.2143C19.8941 14.7087 20.0013 14.1665 20 13.6191V8.3158C20 8.09479 19.9122 7.88283 19.7559 7.72655C19.5996 7.57027 19.3877 7.48247 19.1667 7.48247ZM15.3875 17.6016C15.0525 17.9358 14.6289 18.1671 14.1667 18.2683V15C14.1667 14.779 14.2545 14.567 14.4107 14.4107C14.567 14.2544 14.779 14.1666 15 14.1666H18.2708C18.1677 14.6279 17.9367 15.0507 17.6042 15.3866L15.3875 17.6016Z"
                      fill="#374957"
                    />
                  </g>
                  <defs>
                    <clipPath id="clip0_41_2780">
                      <rect width="20" height="20" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
              </button>
              <button class="mr-2 table-btn" @click="deleteRole(item.id)">
                <svg
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <g clip-path="url(#clip0_41_2783)">
                    <path
                      d="M12.4994 3.20713C12.502 3.37285 12.5531 3.53419 12.6462 3.67129C12.7393 3.8084 12.8705 3.91528 13.0236 3.97879C14.3921 4.58095 15.5494 5.57838 16.3469 6.84305C17.1445 8.10771 17.5458 9.58188 17.4994 11.0763C17.4671 13.0654 16.646 14.9603 15.2167 16.344C13.7873 17.7277 11.8669 18.4869 9.87775 18.4546C7.88862 18.4224 5.99379 17.6012 4.61008 16.1719C3.22638 14.7426 2.46715 12.8221 2.49941 10.833C2.50134 9.37982 2.92537 7.95852 3.71996 6.74186C4.51454 5.5252 5.64547 4.56557 6.97525 3.97963C7.12841 3.91573 7.25959 3.80853 7.35269 3.67116C7.44581 3.53379 7.4968 3.37223 7.49941 3.20629C7.49963 3.0698 7.46631 2.93535 7.4024 2.81475C7.33848 2.69414 7.24592 2.59109 7.13284 2.51464C7.01977 2.43819 6.88965 2.39068 6.75392 2.37629C6.61819 2.36191 6.481 2.38108 6.35441 2.43213C4.42048 3.27058 2.8346 4.74991 1.86388 6.62095C0.893169 8.492 0.596938 10.6404 1.02509 12.7043C1.45324 14.7683 2.57961 16.6216 4.21447 17.9521C5.84934 19.2826 7.8928 20.0091 10.0007 20.0091C12.1085 20.0091 14.152 19.2826 15.7869 17.9521C17.4217 16.6216 18.5481 14.7683 18.9762 12.7043C19.4044 10.6404 19.1082 8.492 18.1374 6.62095C17.1667 4.74991 15.5808 3.27058 13.6469 2.43213C13.5201 2.38052 13.3826 2.36094 13.2465 2.37512C13.1103 2.38929 12.9798 2.43678 12.8663 2.51338C12.7529 2.58999 12.6601 2.69336 12.5961 2.81436C12.5321 2.93535 12.4989 3.07025 12.4994 3.20713Z"
                      fill="#374957"
                    />
                    <path
                      d="M10.8337 0.833303C10.8337 0.373066 10.4606 -3.05176e-05 10.0003 -3.05176e-05C9.54009 -3.05176e-05 9.16699 0.373066 9.16699 0.833303V5.8333C9.16699 6.29354 9.54009 6.66664 10.0003 6.66664C10.4606 6.66664 10.8337 6.29354 10.8337 5.8333V0.833303Z"
                      fill="#374957"
                    />
                  </g>
                  <defs>
                    <clipPath id="clip0_41_2783">
                      <rect width="20" height="20" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Pagination -->
    <div v-if="!is_loading && role_list.length > 0" class="flex justify-center">
      <fwb-pagination
        v-model="current_page"
        :total-pages="total_page"
      ></fwb-pagination>
    </div>
    <!-- Main modal -->
    <div class="fwb-modal">
      <fwb-modal v-if="is_show_modal" @close="closeModal" persistent size="5xl">
        <template #header>
          <div
            class="flex items-center text-xl font-medium text-gray-900 dark:text-white"
          >
            Add Role
          </div>
        </template>
        <template #body>
          <div class="flex flex-wrap pr-6 pl-3">
            <div class="flex items-start pt-4 w-full">
              <p class="w-56 pl-3 pr-3">Role Name</p>
              <div class="flex flex-col items-start w-full">
                <input
                  type="text"
                  v-model="form.name"
                  :class="{
                    'border-red-500': is_validation && form.name === '',
                  }"
                  class="block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Enter name"
                />
                <span
                  v-if="is_validation && form.name === ''"
                  class="text-red-500"
                >
                  Please enter Role name
                </span>
                <span v-if="is_name_exist" class="text-red-500">
                  {{ is_name_exist }}
                </span>
              </div>
            </div>
            <div class="flex items-start pt-4 w-full">
              <p class="w-56 pl-3 pr-3">Select Permissions</p>
              <ul
                class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white"
              >
                <li
                  v-for="(item, index) in permission_list"
                  :key="index"
                  :value="item.id"
                  class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600"
                >
                  <div class="flex items-center ps-3">
                    <input
                      :id="'vue-checkbox-list' + item.id"
                      type="checkbox"
                      v-model="form.permissions"
                      :value="item.id"
                      :checked="item.id == form.permissions.id"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    />
                    <label
                      :for="'vue-checkbox-list' + item.id"
                      class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                      >{{ item.name }}
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </template>
        <template #footer>
          <div class="flex justify-end gap-3">
            <fwb-button @click="closeModal" color="alternative">
              Decline
            </fwb-button>
            <fwb-button v-if="spinner" color="green" disabled>
              <svg
                aria-hidden="true"
                role="status"
                class="inline w-4 h-4 me-3 text-white animate-spin"
                viewBox="0 0 100 101"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                  fill="#E5E7EB"
                />
                <path
                  d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                  fill="currentColor"
                />
              </svg>
              Loading...
            </fwb-button>
            <fwb-button
              v-else
              @click="isEditing ? updateRoleByID(role_id) : createRole()"
              color="green"
            >
              {{ isEditing ? "Update" : "Submit" }}
            </fwb-button>
          </div>
        </template>
      </fwb-modal>
    </div>
  </div>
</template>
<style></style>