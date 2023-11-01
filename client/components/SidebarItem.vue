<script setup>
const links = [{
  label: 'Profile',
  avatar: {
    src: 'https://avatars.githubusercontent.com/u/739984?v=4'
  },
  badge: 100
}, {
  label: 'Installation',
  icon: 'i-heroicons-home',
  to: ''
}, {
  label: '',
  icon: 'i-heroicons-chart-bar',
  to: ''
}, {
  label: 'Command Palette',
  icon: 'i-heroicons-command-line',
  to: ''
}]
</script>

<template>
  <UVerticalNavigation :links="links" />
</template>

