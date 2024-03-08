
<script setup>
const apiData = ref({});
const isModalVisible = ref(false);

const openModal = (id) => {
  if (id) {
    getUserByID(id);
  }
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
};

// Get user by ID
async function getUserByID(id) {
  try {
    const response = await $http(`/users/${id}`, {
      method: "GET",
    });
    apiData.value = response.data.profile;
  } catch (error) {
    console.log(error);
  }
}

// Define form fields for user profile
const userFormFields = [
  { label: "First Name", name: "first_name", type: "text" },
  { label: "Last Name", name: "last_name", type: "text" },
  { label: "Gender", name: "gender", type: "text" },
  { label: "Date of birth", name: "dob", type: "date" },
  { label: "Blood Group", name: "blood_group", type: "text" },
  { label: "Religion", name: "religion", type: "text" },
];
</script>
<template>
  <Modal
    v-if="isModalVisible"
    :show="isModalVisible"
    :apiData="apiData"
    :formFields="userFormFields"
    :apiEndpoint="`/users/${apiData.user_id}`"
    :method="'PUT'"
    @close="closeModal"
  />
</template>
  
  