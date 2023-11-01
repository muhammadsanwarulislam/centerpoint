<script setup lang="ts">
definePageMeta({
  middleware: "is-logged-in",
});
</script>

<template>
  <div>
    <h1>Welcome to the Index page</h1>
  </div>
</template>
