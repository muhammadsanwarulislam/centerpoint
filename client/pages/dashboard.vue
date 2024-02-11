<script setup>
useHead({ title: 'Dashboard' });
definePageMeta({ middleware: ['auth'] });

// Load Dynamic Component
const component_id = ref(storeUserData().get_component || 'Overview')

const over_view = resolveComponent('RightSideOverview')
const menu_creation = resolveComponent('RightSideMenuCreation')
const user_creation = resolveComponent('RightSideUserCreation')
const role_creation = resolveComponent('RightSideRoleCreation')
const permission_creation = resolveComponent('RightSidePermissionCreation')

const getComponent = computed(() => {
    switch (component_id.value) {
        case 'Overview' : return over_view
        case 'MenuCreation' : return menu_creation
        case 'UserCreation' : return user_creation
        case 'RoleCreation' : return role_creation
        case 'PermissionCreation' : return permission_creation
        default : return over_view
    }
})

watch(() => storeUserData().get_component, (value) => {
    component_id.value = value
    window.scrollTo(0, 0)
})
</script>

<template>
    <TopMenu :title="title='dashboard'" />
    <div class="p-4 sm:ml-64 dashboard_close">
        <div class="p-4 rounded-lg dark:border-gray-700">
            <LeftSide />
            <ClientOnly>
                <KeepAlive>
                    <component :is="getComponent" />
                </KeepAlive>
            </ClientOnly>
        </div>
    </div>
</template>

<style></style>
