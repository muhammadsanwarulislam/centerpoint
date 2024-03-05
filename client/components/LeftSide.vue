<script setup>
// Load Dynamic Component
const { getComponent } = storeUserData();
const component_id = ref(storeUserData().get_component || "Overview");
const openSubmenu = ref(null);

watch(
  () => storeUserData().get_component,
  (value) => {
    component_id.value = value;
  }
);
const menus = storeUserData().user_data.role.get_menus_according_to_the_role_id;

function loadComponent(component) {
  getComponent(component);
}

function loadComponentOrSubMenu(menu) {
  if (hasSubmenu(menu.id)) {
    toggleSubMenu(menu.id);
  } else {
    loadComponent(menu.component);
  }
}

function toggleSubMenu(menuId) {
  openSubmenu.value = openSubmenu.value === menuId ? null : menuId;
}

function hasSubmenu(menuId) {
  return menus.some((menu) => menu.pivot.parent_id === menuId);
}
</script>

<template>
  <div>
    <!-- Left Side Start -->
    <aside
      id="separator-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 sidebar"
      aria-label="Sidebar"
    >
      <div
        class="h-full px-3 pb-4 pt-4 overflow-y-auto bg-white dark:bg-gray-800"
      >
        <a href="/" class="flex items-center ps-2.5 mb-5">
          <span
            class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"
            >Centerpoint</span
          >
        </a>
        <ul class="space-y-2 font-medium">
          <!-- Loop through top-level menus -->
          <template v-for="(item, index) in menus">
            <!-- Check if the menu item has a parent -->

            <template v-if="!item.pivot.parent_id">
              <li :key="index">
                <button
                  type="button"
                  @click="loadComponentOrSubMenu(item)"
                  :class="{
                    'bg-gray-100 dark:bg-gray-700':
                      component_id === item.component,
                  }"
                  class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                >
                  <span
                    class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"
                    >{{ item.name }}</span
                  >
                  <span v-if="hasSubmenu(item.id)" class="mr-2">
                    <svg
                      :class="{
                        'transform rotate-90': openSubmenu === item.id,
                      }"
                      class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor"
                      viewBox="0 0 22 21"
                    >
                      <path
                        d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
                      />
                      <path
                        d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
                      />
                    </svg>
                  </span>
                </button>
                <!-- Render child menus -->
                <ul v-if="openSubmenu === item.id">
                  <template v-for="(child, childIndex) in menus">
                    <li
                      v-if="child.pivot.parent_id === item.id"
                      :key="childIndex"
                    >
                      <button
                        type="button"
                        @click="loadComponent(child.component)"
                        :class="{
                          'bg-gray-100 dark:bg-gray-700':
                            component_id === child.component,
                        }"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                      >
                        <span
                          class="flex-1 ms-6 text-left rtl:text-right whitespace-nowrap"
                          >{{ child.name }}</span
                        >
                      </button>
                    </li>
                  </template>
                </ul>
              </li>
            </template>
          </template>
        </ul>
        <ul
          class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
        >
          <nuxt-link class="ml-5" to="/profile">Profile</nuxt-link>
        </ul>
      </div>
    </aside>
    <!-- Left Side End -->
  </div>
</template>

<style></style>
