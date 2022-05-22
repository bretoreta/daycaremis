<template>
  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />

    <!-- Content area -->
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
      
      <!-- Site header -->
      <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />

      <main>
        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

          <!-- Welcome banner -->
          <WelcomeBanner />
          
          <!-- Dashboard actions -->
          <div class="sm:flex sm:justify-between sm:items-center mb-8">
              <dashboard-widget :name="`Admins`" :icon="'admins'" :count="count.admins" :containerClasses="`bg-green-500`" :textClasses="`text-green-700`" />
              <dashboard-widget :name="`Staff`" :icon="'staff'" :count="count.staff" :containerClasses="`bg-red-500`" :textClasses="`text-red-700`" />
              <dashboard-widget :name="`Parents`" :icon="'parents'" :count="count.parents  " :containerClasses="`bg-blue-500`" :textClasses="`text-blue-700`" />
              <dashboard-widget :name="`Children`" :icon="'children'" :count="count.children" :containerClasses="`bg-yellow-500`" :textClasses="`text-yellow-700`" />
              <dashboard-widget :name="`Meals`" :icon="'meals'" :count="count.meals" :containerClasses="`bg-pink-500`" :textClasses="`text-pink-700`" />
          </div>

          <div class="grid grid-cols-6 gap-4">
            <div class="col-span-6 col-span-4">
              <div class="border border-gray-300 rounded-lg shadow w-full px-8 py-5">
                <h3 class="font-bold mb-4">Recent Attendances</h3>
                <table class="min-w-full divide-y divide-gray-200 max-h-[400px]">
                  <thead class="bg-gray-50">
                      <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caretaker Name</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Child Name</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                      </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="attendance in $page.props.attendances" :key="attendance.id" class="bg-white hover:bg-gray-50 duration-200">
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ attendance.caretaker.name }}</div>
                            </div>  
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ attendance.child.first_name + ' ' + attendance.child.last_name }}</td>
                          <td class="px-6 py-4 whitespace-nowrap">
                              <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" :class="attendance.pick_up ? 'bg-green-200 text-green-900' : 'bg-yellow-200 text-yellow-900'">{{ attendance.pick_up ? 'Picked Up' : 'In Care' }}</span>
                          </td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-span-6 sm:col-span-2">
              <div class="border border-gray-300 rounded-lg shadow max-h-[450px] overflow-y-auto no-scrollbar w-full px-8 py-5">
                <h3 class="font-bold">Recent Actions</h3>
                <div class="mt-4">
                  <ol v-for="action in $page.props.actions" :key="action.id" class="relative border-l border-gray-200">                  
                    <li class="pb-10 ml-6">            
                        <div class="absolute -left-3">
                            <img class="rounded-full shadow-lg object-cover rounded-full w-6 h-6" :src="action.responsible_user.profile_photo_url" alt="Bonnie image"/>
                        </div>
                        <div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="text-sm font-normal text-gray-800">{{ action.responsible_user.name == $page.props.user.name ? 'You' : action.responsible_user.name}} {{ action.action_done + ': ' + action.affected_record.name }}</div>
                            <div class="flex items-center justify-between text-gray-400 mt-3">
                              <span class="text-gray-500 text-xs italic uppercase">{{ action.responsible_role }} action</span>
                              <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">{{ action.created_at }}</time>
                            </div>
                        </div>
                    </li>
                </ol>
                </div>
              </div>
            </div>
          </div>

        </div>
      </main>

      <Banner />

    </div> 

  </div>
</template>

<script>
import { ref } from 'vue'
import Sidebar from '@/Partials/Admin/Sidebar.vue'
import Header from '@/Partials/Admin/Header.vue'
import WelcomeBanner from '@/Partials/Admin/dashboard/WelcomeBanner.vue'
import FilterButton from '@/Components/DropdownFilter.vue'
import DashboardWidget from '@/Components/DashboardWidget.vue'
import Banner from '@/Partials/Admin/Banner.vue'

export default {
  name: 'Dashboard',
  components: {
    Sidebar,
    Header,
    WelcomeBanner,
    FilterButton,
    DashboardWidget,
    Banner,
  },
  props: ["count", 'actions', 'attendances'],
  setup() {

    const sidebarOpen = ref(false)

    return {
      sidebarOpen,
    } 
  }
}
</script>