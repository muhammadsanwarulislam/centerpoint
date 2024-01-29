<script setup>
useHead({ title: 'Dashboard' });
definePageMeta({ middleware: ['auth'] });

// Load Dynamic Component
const component_id = ref(storeUserData().get_component || 'Overview')

const over_view = resolveComponent('RightSideOverview')
const school = resolveComponent('RightSideSchool')
const payment = resolveComponent('RightSidePayment')
const report = resolveComponent('RightSideReport')
const attendance_device = resolveComponent('RightSideAttendanceDevice')
const user_creation = resolveComponent('RightSideUserCreation')
const role_creation = resolveComponent('RightSideRoleCreation')

const getComponent = computed(() => {
    switch (component_id.value) {
        case 'Overview' : return over_view
        case 'School' : return school
        case 'Payment' : return payment
        case 'Report' : return report
        case 'AttendanceDevice' : return attendance_device
        case 'UserCreation' : return user_creation
        case 'RoleCreation' : return role_creation
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
