<template>
  <div>
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true"></div>

    <!-- Sidebar -->
    <div
      id="sidebar"
      ref="sidebar"
      class="flex flex-col justify-between absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 transform h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-gray-800 p-4 transition-all duration-200 ease-in-out"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'"
    >

      <div>
        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
          <!-- Close button -->
          <button
            ref="trigger"
            class="lg:hidden text-gray-500 hover:text-gray-400"
            @click.stop="$emit('close-sidebar')"
            aria-controls="sidebar"
            :aria-expanded="sidebarOpen"
          >
            <span class="sr-only">Close sidebar</span>
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
            </svg>
          </button>
          <!-- Logo -->
          <div class="mt-5">
            <svg width="32" height="32" viewBox="0 0 32 32" class="w-16 h-16">
              <defs>
                <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                  <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                  <stop stop-color="#A5B4FC" offset="100%" />
                </linearGradient>
                <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                  <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                  <stop stop-color="#38BDF8" offset="100%" />
                </linearGradient>
              </defs>
              <rect fill="#6366F1" width="32" height="32" rx="16" />
              <path d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z" fill="#4F46E5" />
              <path d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z" fill="url(#logo-a)" />
              <path d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z" fill="url(#logo-b)" />
            </svg>
            <p class="mt-2 text-sm text-blue-500">DaycareMIS</p>
          </div>
        </div>

        <!-- Links -->
        <div class="space-y-8">
          <!-- Pages group -->
          <div class="mt-4">
            <h3 class="text-xs uppercase text-blue-500 font-semibold pl-3">
              <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
            </h3>
            <ul class="pl-3 flex flex-col">
              <!-- Dashboard -->
                <dashboard-link :href="route(  $page.props.user.roles[0].name + '.dashboard')" :active="route().current(  $page.props.user.roles[0].name + '.dashboard')">Dashboard</dashboard-link>
                <div class="border-b border-gray-600 mt-4"></div>
                <dashboard-link v-if="$page.props.user.roles[0].name == 'admin'" :href="route('admin.admins.index')" :active="route().current('admin.admins.*')">Admins</dashboard-link>
                <dashboard-link v-if="$page.props.user.roles[0].name != 'parent'" :href="route( $page.props.user.roles[0].name + '.staff.index')" :active="route().current( $page.props.user.roles[0].name + '.staff.*')">Staff</dashboard-link>
                <dashboard-link v-if="$page.props.user.roles[0].name != 'parent'" :href="route( $page.props.user.roles[0].name + '.parents.index')" :active="route().current( $page.props.user.roles[0].name + '.parents.*')">Parents</dashboard-link>
                <dashboard-link :href="route( $page.props.user.roles[0].name + '.children.index')" :active="route().current( $page.props.user.roles[0].name + '.children.*')">Children</dashboard-link>
                <dashboard-link :href="route( $page.props.user.roles[0].name + '.meals.index')" :active="route().current( $page.props.user.roles[0].name + '.meals.*')">Meals</dashboard-link>
                <dashboard-link :href="route( $page.props.user.roles[0].name + '.attendances.index')" :active="route().current( $page.props.user.roles[0].name + '.attendances.*')">Attendance</dashboard-link>
                <div v-if="$page.props.user.roles[0].name == 'parent'" class="border-b border-gray-600 mt-5"></div>
                <dashboard-link v-if="$page.props.user.roles[0].name == 'parent'" :href="route('complaints.show')" :active="route().current('complaints.*')">Complaints</dashboard-link>
                <!-- <dashboard-link :href="route('feedback.show')">Feedback</dashboard-link> -->
            </ul>
          </div>
        </div>
      </div>

      <div class="mt-6">
        <h3 class="text-xs text-gray-500 uppercase text-center">Infinity Labs ❤ <span class="text-xs">V 1.0.1</span> </h3>
      </div>

      <!-- Expand / collapse button -->
      <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
        <div class="px-3 py-2">
          <button @click.prevent="sidebarExpanded = !sidebarExpanded">
            <span class="sr-only">Expand / collapse sidebar</span>
            <svg class="w-6 h-6 fill-current sidebar-expanded:rotate-180" viewBox="0 0 24 24">
              <path class="text-gray-400" d="M19.586 11l-5-5L16 4.586 23.414 12 16 19.414 14.586 18l5-5H7v-2z" />
              <path class="text-gray-600" d="M3 23H1V1h2z" />
            </svg>
          </button>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import SidebarLinkGroup from './SidebarLinkGroup.vue'
import DashboardLink from "@/Components/DashboardLink.vue"

export default {
  name: 'Sidebar',
  props: ['sidebarOpen'],
  components: {
    SidebarLinkGroup,
    DashboardLink,
  },
  setup(props, { emit }) {

    const trigger = ref(null)
    const sidebar = ref(null)

    const storedSidebarExpanded = localStorage.getItem('sidebar-expanded')
    const sidebarExpanded = ref(storedSidebarExpanded === null ? false : storedSidebarExpanded === 'true')

    // close on click outside
    const clickHandler = ({ target }) => {
      if (!sidebar.value || !trigger.value) return
      if (
        !props.sidebarOpen ||
        sidebar.value.contains(target) ||
        trigger.value.contains(target)
      ) return
      emit('close-sidebar')
    }

    // close if the esc key is pressed
    const keyHandler = ({ keyCode }) => {
      if (!props.sidebarOpen || keyCode !== 27) return
      emit('close-sidebar')
    } 

    onMounted(() => {
      document.addEventListener('click', clickHandler)
      document.addEventListener('keydown', keyHandler)
    })

    onUnmounted(() => {
      document.removeEventListener('click', clickHandler)
      document.removeEventListener('keydown', keyHandler)
    })

    watch(sidebarExpanded, () => {
      localStorage.setItem('sidebar-expanded', sidebarExpanded.value)
      if (sidebarExpanded.value) {
        document.querySelector('body').classList.add('sidebar-expanded')
      } else {
        document.querySelector('body').classList.remove('sidebar-expanded')
      }
    })

    return {
      trigger,
      sidebar,
      sidebarExpanded,
    }
  },
}
</script>