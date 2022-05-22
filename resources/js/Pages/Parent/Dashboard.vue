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
          
          <div>
            <div class="border border-gray-300 rounded-lg shadow w-full px-8 py-5">
                <h3 class="font-bold mb-4">Recent Attendances</h3>
                <table v-if="$page.props.attendances.length > 0" class="min-w-full divide-y divide-gray-200  max-h-[400px]">
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
                <div v-else class="bg-orange-500 px-12 py-6 shadow flex items-center space-x-4 text-white">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="exclamation-circle" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                  <p class="text-sm">There are no Attendances currently in the system. Please admit your children to our facility</p>
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
import Banner from '@/Partials/Admin/Banner.vue'

export default {
  name: 'Dashboard',
  components: {
    Sidebar,
    Header,
    WelcomeBanner,
    FilterButton,
    Banner,
  },
  props: ['actions', 'attendances'],
  setup() {

    const sidebarOpen = ref(false)

    return {
      sidebarOpen,
    } 
  }
}
</script>