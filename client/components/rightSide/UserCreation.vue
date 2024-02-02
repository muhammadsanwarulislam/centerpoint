<script setup>
import { FwbButton, FwbModal, FwbPagination } from "flowbite-vue";

// Get user list
const user_list = ref([]);
const current_page = ref(1);
const total_page = ref(0);
const limit = ref(5);
const is_loading = ref(false);
const search_data = ref("");
const user_id = ref(null);

async function getUserList() {
  try {
    user_list.value = [];
    is_loading.value = true;
    const response = await $http(
      `/users?option=search&offset=${current_page.value}&limit=${limit.value}&searchData=${search_data.value}`,
      {
        method: "GET",
      }
    );
    user_list.value = response.data;
    total_page.value = Math.ceil(response.total / limit.value);
  } catch (error) {
    user_list.value = [];
  } finally {
    is_loading.value = false;
  }
}

onMounted(() => {
  getUserList();
});

watch([current_page, search_data], () => {
  getUserList();
});

const isEditing = computed(() => !!user_id.value);

// Get role
const role_list = ref([]);

async function getRoleList() {
  try {
    const response = await $http(`/roles`, {
      method: "GET",
    });
    role_list.value = response.data;
  } catch (error) {
    console.log(error);
  }
}

//Get user by ID
async function getUserByID(id) {
    try {
        const response = await $http(`/users/${id}`, {
            method: "GET",
        });
        let data = response.data;
        form.value = {
            username: data.username,
            email:data.email,
            role:data.role.id
        };
        user_id.value = id;
    } catch (error) {
        console.log(error);
    }
}

// create user Modal
const is_show_modal = ref(false);
const is_validation = ref(false);
const is_username_exist = ref("");
const is_email_exist = ref("");

function closeModal() {
  is_show_modal.value = false;
  is_validation.value = false;
  reset();
  form.value = {
    username: "",
    email: "",
    role_id: "",
  };
}
function showModal(id) {
  is_show_modal.value = true;
  if(id) {
    getUserByID(id);
  }
  getRoleList();
}

// post create user
const spinner = ref(false);
const form = ref({
  username: "",
  email: "",
  role_id: "",
});

async function createUser() {
  try {
    reset();
    if (
      form.value.username === "" ||
      form.value.email === "" ||
      form.value.role_id === ""
    ) {
      is_validation.value = true;
      return;
    }
    spinner.value = true;
    const response = await $http(`/users`, {
      method: "POST",
      body: form.value,
    });
    push.success(response.message);
    user_list.value.unshift(response.data);
    closeModal();
  } catch (error) {
    console.log(error);

    const errors = error.data?.errors;
    const defaultMessage = error.data?.message;
    if (errors) {
      if (errors.username) {
        is_username_exist.value = errors.username[0];
      }

      if (errors.email) {
        is_email_exist.value = errors.email[0];
      }
    } else {
      push.error(defaultMessage || "An unknown error occurred");
    }
  } finally {
    spinner.value = false;
  }
}

async function updateUserByID(id) {
  try {
    reset();
    if (
      form.value.username === "" ||
      form.value.email === "" ||
      form.value.role_id === ""
    ) {
      is_validation.value = true;
      return;
    }
    spinner.value = true;
    const response = await $http(`/users/${id}`, {
      method: "PUT",
      body: form.value,
    });
    push.success(response.message);
    closeModal();
  } catch (error) {
    console.log(error);

    const errors = error.data?.errors;
    const defaultMessage = error.data?.message;
    if (errors) {
      if (errors.username) {
        is_username_exist.value = errors.username[0];
      }

      if (errors.email) {
        is_email_exist.value = errors.email[0];
      }
    } else {
      push.error(defaultMessage || "An unknown error occurred");
    }
  } finally {
    spinner.value = false;
  }
}

async function deleteUser(id) {
  try {
    const response = await $http(`/users/${id}`, {
      method: "DELETE",
      body: form.value,
    });
    // Remove the deleted user from the list
    const index = user_list.value.findIndex((item) => item.id === id);
    if (index !== -1) {
      user_list.value.splice(index, 1);
    }

    push.success(response.message);
  } catch (error) {
    console.log(error);
  }
}

function reset() {
  is_validation.value = false;
  is_username_exist.value = "";
  is_email_exist.value = "";
}
</script>
<template>
  <div>
    <h1 class="text-2xl font-bold pb-3">User Creations</h1>
    <!-- <div class="flex flex-wrap">
            <div v-for="item in 4" :key="item" class="w-full sm:w-1/2 lg:w-1/4 pr-3 pb-3">
                <div
                    class="block max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="flex justify-center items-center py-2">
                        <p class="text-4xl font-bold"> 63 </p>
                    </div>
                    <h5 class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white text-center">
                        Total Collection
                    </h5>
                </div>
            </div>
        </div> -->
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
            v-on:keyup.enter="getUserList"
            class="bg-white block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Type Person Name"
          />
          <!-- <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button> -->
        </div>
      </div>

      <div class="flex flex-wrap items-center justify-between gap-3">
        <!-- <div class="flex flex-wrap items-center gap-3 sm-justify-end">
                    <div class="flex items-center">
                        <span class="text-gray-700 dark:text-gray-400 pr-3">From</span>
                        <input type="date"
                            class="bg-white block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select Date">
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700 dark:text-gray-400 pr-3">To</span>
                        <input type="date"
                            class="bg-white block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select Date">
                    </div>
                </div> -->
        <button class="button bg-white">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g clip-path="url(#clip0_13_324)">
              <path
                d="M19 6V4C19 2.93913 18.5786 1.92172 17.8284 1.17157C17.0783 0.421427 16.0609 0 15 0L9 0C7.93913 0 6.92172 0.421427 6.17157 1.17157C5.42143 1.92172 5 2.93913 5 4V6C3.67441 6.00159 2.40356 6.52888 1.46622 7.46622C0.528882 8.40356 0.00158786 9.67441 0 11L0 16C0.00158786 17.3256 0.528882 18.5964 1.46622 19.5338C2.40356 20.4711 3.67441 20.9984 5 21C5 21.7956 5.31607 22.5587 5.87868 23.1213C6.44129 23.6839 7.20435 24 8 24H16C16.7956 24 17.5587 23.6839 18.1213 23.1213C18.6839 22.5587 19 21.7956 19 21C20.3256 20.9984 21.5964 20.4711 22.5338 19.5338C23.4711 18.5964 23.9984 17.3256 24 16V11C23.9984 9.67441 23.4711 8.40356 22.5338 7.46622C21.5964 6.52888 20.3256 6.00159 19 6ZM7 4C7 3.46957 7.21071 2.96086 7.58579 2.58579C7.96086 2.21071 8.46957 2 9 2H15C15.5304 2 16.0391 2.21071 16.4142 2.58579C16.7893 2.96086 17 3.46957 17 4V6H7V4ZM17 21C17 21.2652 16.8946 21.5196 16.7071 21.7071C16.5196 21.8946 16.2652 22 16 22H8C7.73478 22 7.48043 21.8946 7.29289 21.7071C7.10536 21.5196 7 21.2652 7 21V17C7 16.7348 7.10536 16.4804 7.29289 16.2929C7.48043 16.1054 7.73478 16 8 16H16C16.2652 16 16.5196 16.1054 16.7071 16.2929C16.8946 16.4804 17 16.7348 17 17V21ZM22 16C22 16.7956 21.6839 17.5587 21.1213 18.1213C20.5587 18.6839 19.7956 19 19 19V17C19 16.2044 18.6839 15.4413 18.1213 14.8787C17.5587 14.3161 16.7956 14 16 14H8C7.20435 14 6.44129 14.3161 5.87868 14.8787C5.31607 15.4413 5 16.2044 5 17V19C4.20435 19 3.44129 18.6839 2.87868 18.1213C2.31607 17.5587 2 16.7956 2 16V11C2 10.2044 2.31607 9.44129 2.87868 8.87868C3.44129 8.31607 4.20435 8 5 8H19C19.7956 8 20.5587 8.31607 21.1213 8.87868C21.6839 9.44129 22 10.2044 22 11V16Z"
                fill="#374957"
              />
              <path
                d="M18 10.0003H16C15.7348 10.0003 15.4804 10.1057 15.2929 10.2932C15.1054 10.4807 15 10.7351 15 11.0003C15 11.2655 15.1054 11.5199 15.2929 11.7074C15.4804 11.8949 15.7348 12.0003 16 12.0003H18C18.2652 12.0003 18.5196 11.8949 18.7071 11.7074C18.8946 11.5199 19 11.2655 19 11.0003C19 10.7351 18.8946 10.4807 18.7071 10.2932C18.5196 10.1057 18.2652 10.0003 18 10.0003Z"
                fill="#374957"
              />
            </g>
            <defs>
              <clipPath id="clip0_13_324">
                <rect width="24" height="24" fill="white" />
              </clipPath>
            </defs>
          </svg>
        </button>
        <button class="button bg-white">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g clip-path="url(#clip0_13_331)">
              <path
                d="M9.87823 18.122C10.1568 18.4008 10.4876 18.6219 10.8517 18.7728C11.2158 18.9237 11.6061 19.0014 12.0002 19.0014C12.3944 19.0014 12.7846 18.9237 13.1487 18.7728C13.5128 18.6219 13.8436 18.4008 14.1222 18.122L17.3332 14.911C17.5054 14.7206 17.5977 14.4713 17.5911 14.2147C17.5846 13.958 17.4795 13.7138 17.2978 13.5325C17.1161 13.3512 16.8716 13.2467 16.615 13.2406C16.3584 13.2346 16.1093 13.3274 15.9192 13.5L12.9932 16.427L13.0002 1C13.0002 0.734784 12.8949 0.48043 12.7073 0.292893C12.5198 0.105357 12.2654 0 12.0002 0V0C11.735 0 11.4807 0.105357 11.2931 0.292893C11.1056 0.48043 11.0002 0.734784 11.0002 1L10.9912 16.408L8.08123 13.5C7.89359 13.3125 7.63914 13.2072 7.37387 13.2073C7.1086 13.2074 6.85423 13.3129 6.66673 13.5005C6.47922 13.6881 6.37393 13.9426 6.37402 14.2079C6.37412 14.4731 6.47959 14.7275 6.66723 14.915L9.87823 18.122Z"
                fill="#374957"
              />
              <path
                d="M23 15.9998C22.7348 15.9998 22.4804 16.1052 22.2929 16.2927C22.1054 16.4803 22 16.7346 22 16.9998V20.9998C22 21.2651 21.8946 21.5194 21.7071 21.7069C21.5196 21.8945 21.2652 21.9998 21 21.9998H3C2.73478 21.9998 2.48043 21.8945 2.29289 21.7069C2.10536 21.5194 2 21.2651 2 20.9998V16.9998C2 16.7346 1.89464 16.4803 1.70711 16.2927C1.51957 16.1052 1.26522 15.9998 1 15.9998C0.734784 15.9998 0.48043 16.1052 0.292893 16.2927C0.105357 16.4803 0 16.7346 0 16.9998L0 20.9998C0 21.7955 0.31607 22.5585 0.87868 23.1212C1.44129 23.6838 2.20435 23.9998 3 23.9998H21C21.7956 23.9998 22.5587 23.6838 23.1213 23.1212C23.6839 22.5585 24 21.7955 24 20.9998V16.9998C24 16.7346 23.8946 16.4803 23.7071 16.2927C23.5196 16.1052 23.2652 15.9998 23 15.9998Z"
                fill="#374957"
              />
            </g>
            <defs>
              <clipPath id="clip0_13_331">
                <rect width="24" height="24" fill="white" />
              </clipPath>
            </defs>
          </svg>
        </button>
        <button class="button btn" @click="showModal">+ Add User</button>
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
            <th scope="col" class="px-4 py-4">Name</th>
            <th scope="col" class="px-4 py-4 text-left">Email</th>
            <th scope="col" class="px-4 py-4 text-center">Role</th>
            <th scope="col" class="px-4 py-4 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-if="is_loading"
            class="bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 h-80"
          >
            <td colspan="5">
              <div class="flex justify-center">
                <div class="loader-three-dots"></div>
              </div>
            </td>
          </tr>
          <tr
            v-else-if="!is_loading && user_list.length === 0"
            class="bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 h-80"
          >
            <td colspan="5">
              <div class="flex justify-center">
                <p class="text-gray-500 dark:text-gray-400">No data found</p>
              </div>
            </td>
          </tr>
          <tr
            v-else
            v-for="(item, index) in user_list"
            :key="index"
            class="odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
          >
            <td class="px-2 py-4 text-center">
              {{ limit * (current_page - 1) + index + 1 }}
            </td>
            <th
              scope="row"
              class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ item.username }}
            </th>
            <td class="px-4 py-4 text-left text-gray-900">
              {{ item.email }}
            </td>
            <td class="px-4 py-4 text-center text-gray-900">
              {{ item.role?.name }}
            </td>
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
              <button class="mr-2 table-btn">
                <svg
                  width="17"
                  height="21"
                  viewBox="0 0 17 21"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M12.75 12.1242C12.75 12.345 12.6604 12.5567 12.501 12.7129C12.3416 12.869 12.1254 12.9567 11.9 12.9567H5.09999C4.87456 12.9567 4.65836 12.869 4.49895 12.7129C4.33955 12.5567 4.24999 12.345 4.24999 12.1242C4.24999 11.9034 4.33955 11.6917 4.49895 11.5356C4.65836 11.3794 4.87456 11.2917 5.09999 11.2917H11.9C12.1254 11.2917 12.3416 11.3794 12.501 11.5356C12.6604 11.6917 12.75 11.9034 12.75 12.1242ZM9.34999 14.6217H5.09999C4.87456 14.6217 4.65836 14.7094 4.49895 14.8655C4.33955 15.0216 4.24999 15.2334 4.24999 15.4542C4.24999 15.6749 4.33955 15.8867 4.49895 16.0428C4.65836 16.1989 4.87456 16.2866 5.09999 16.2866H9.34999C9.57542 16.2866 9.79162 16.1989 9.95103 16.0428C10.1104 15.8867 10.2 15.6749 10.2 15.4542C10.2 15.2334 10.1104 15.0216 9.95103 14.8655C9.79162 14.7094 9.57542 14.6217 9.34999 14.6217ZM17 9.19803V16.2866C16.9986 17.3902 16.5504 18.4481 15.7537 19.2285C14.957 20.0088 13.8767 20.4477 12.75 20.4491H4.24999C3.12324 20.4477 2.04302 20.0088 1.24629 19.2285C0.449549 18.4481 0.00134968 17.3902 0 16.2866V4.63186C0.00134968 3.52832 0.449549 2.47036 1.24629 1.69005C2.04302 0.909726 3.12324 0.470762 4.24999 0.469441H8.08774C8.86941 0.46747 9.64373 0.61728 10.3659 0.910207C11.0881 1.20313 11.7439 1.63337 12.2952 2.17603L15.2566 5.07807C15.811 5.61772 16.2506 6.25975 16.5498 6.96696C16.8491 7.67417 17.0021 8.4325 17 9.19803ZM11.0933 3.35316C10.8258 3.09939 10.5255 2.88108 10.2 2.70383V6.29683C10.2 6.51762 10.2895 6.72936 10.4489 6.88548C10.6084 7.0416 10.8246 7.12931 11.05 7.12931H14.7186C14.5375 6.81063 14.3143 6.51673 14.0547 6.2552L11.0933 3.35316ZM15.3 9.19803C15.3 9.06067 15.2728 8.92914 15.26 8.79428H11.05C10.3737 8.79428 9.72508 8.53116 9.24687 8.06279C8.76865 7.59443 8.49999 6.95919 8.49999 6.29683V2.17354C8.36229 2.16105 8.22714 2.13441 8.08774 2.13441H4.24999C3.57369 2.13441 2.92509 2.39753 2.44687 2.8659C1.96866 3.33426 1.7 3.96949 1.7 4.63186V16.2866C1.7 16.949 1.96866 17.5842 2.44687 18.0526C2.92509 18.521 3.57369 18.7841 4.24999 18.7841H12.75C13.4263 18.7841 14.0749 18.521 14.5531 18.0526C15.0313 17.5842 15.3 16.949 15.3 16.2866V9.19803Z"
                    fill="#374957"
                  />
                </svg>
              </button>
              <button class="mr-2 table-btn" @click="deleteUser(item.id)">
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
    <div v-if="!is_loading && user_list.length > 0" class="flex justify-center">
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
            class="flex items-center text-lg text-xl font-medium text-gray-900 dark:text-white"
          >
            Add User
          </div>
        </template>
        <template #body>
          <div class="flex flex-wrap pr-6 pl-3">
            <div class="flex items-start pt-4 w-full sm:w-1/2 lg:w-1/2">
              <p class="w-56 pl-3 pr-3">User Name</p>
              <div class="flex flex-col items-start w-full">
                <input
                  type="text"
                  v-model="form.username"
                  :class="{
                    'border-red-500': is_validation && form.username === '',
                  }"
                  class="bg-white block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Enter Username"
                />
                <span
                  v-if="is_validation && form.username === ''"
                  class="text-red-500"
                >
                  Please enter user name
                </span>
                <span v-if="is_username_exist" class="text-red-500">
                  {{ is_username_exist }}
                </span>
              </div>
            </div>
            <div class="flex items-start pt-4 w-full sm:w-1/2 lg:w-1/2">
              <p class="w-56 pl-3 pr-3">Email</p>
              <div class="flex flex-col items-start w-full">
                <input
                  type="text"
                  v-model="form.email"
                  :class="{
                    'border-red-500': is_validation && form.email === '',
                  }"
                  class="bg-white block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Enter Email"
                />
                <span
                  v-if="is_validation && form.email === ''"
                  class="text-red-500"
                  >Please enter email
                </span>
                <span v-if="is_email_exist" class="text-red-500">
                  {{ is_email_exist }}
                </span>
              </div>
            </div>
            <div class="flex items-start pt-4 w-full sm:w-1/2 lg:w-1/2">
              <label
                for="activity"
                class="w-56 block pl-3 pr-3 text-sm font-medium text-gray-900 dark:text-white"
                >Role</label
              >
              <div class="flex flex-col items-start w-full">
                <select
                  id="activity"
                  v-model="form.role_id"
                  :class="{
                    'border-red-500': is_validation && form.role_id === '',
                  }"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                  <option selected disabled value="">Select Role</option>
                  <option
                    v-for="(item, index) in role_list"
                    :key="index"
                    :value="item.id"
                  >
                    {{ item.name }}
                  </option>
                </select>
                <span
                  v-if="is_validation && form.role_id === ''"
                  class="text-red-500"
                  >Please select role
                </span>
              </div>
            </div>
            <!-- <div class="flex items-center pt-4 w-full sm:w-1/2 lg:w-1/2">
                            <p class="w-56 pl-3 pr-3">Mobile</p>
                            <input type="text"
                                class="bg-white block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Mobile">
                        </div>
                        <div class="flex items-center pt-4 w-full">
                            <p class="w-56 small-s-w pl-3 pr-3">Address</p>
                            <input type="text"
                                class="bg-white block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Address">
                        </div> -->
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
            <fwb-button v-else @click="isEditing ? updateUserByID(role_id) : createUser()" color="green">
                            {{ isEditing ? "Update" : "Submit"}}
                        </fwb-button>
          </div>
        </template>
      </fwb-modal>
    </div>
  </div>
</template>

<style></style>