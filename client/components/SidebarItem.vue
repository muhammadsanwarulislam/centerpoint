<script setup>
const links = [ {
  label: 'Dashboard',
  icon: 'i-heroicons-home',
  to: ''
}, {
  label: 'User Management',
  icon: 'i-heroicons-user-group',
  to: 'backend/usermanagement'
}, {
  label: 'Settings',
  icon: 'i-heroicons-bars-4-solid',
  to: ''
}]
</script>

<template>
  <UVerticalNavigation :links="links" />
</template>


