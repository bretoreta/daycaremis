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

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="my-6 flex justify-between items-center sm:px-6 lg:px-8">
                            <h3 class="text-3xl">Attendances</h3>
                            <button v-if="can.add" @click="showingModal = true" class="bg-blue-500 text-white py-2 px-8 shadow rounded text-sm uppercase hover:bg-blue-600">Add New</button>
                        </div>
                        <div v-if="$page.props.attendances.length > 0" class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caretaker Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Child Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="attendance in $page.props.attendances" :key="attendance.id" class="bg-white hover:bg-gray-50 duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <Link :href="`/admin/attendances/` + attendance.id">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ attendance.caretaker.name }}</div>
                                            </div>
                                        </Link>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ attendance.child.first_name + ' ' + attendance.child.last_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" :class="attendance.pick_up ? 'bg-green-200 text-green-900' : 'bg-yellow-200 text-yellow-900'">{{ attendance.pick_up ? 'Picked Up' : 'In Care' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-center">
                                      <button v-if="! attendance.pick_up && can.edit" @click="markChildPicked(attendance.id)" class="text-green-600 hover:text-green-900 flex items-center mr-5">
                                          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="badge-check" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                          Picked
                                        </button>
                                        <Link v-if="can.read" :href="`/admin/attendances/` + attendance.id" class="text-blue-600 hover:text-blue-900 mr-5 flex items-center">
                                          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                          View
                                        </Link>
                                        <button v-if="can.delete" @click="confirmingUserDeletion = true" class="text-red-600 hover:text-red-900 flex items-center">
                                          <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                          Delete
                                        </button>
                                    </td>

                                    <jet-dialog-modal :show="confirmingUserDeletion">
                                      <template #title>
                                          Delete Attendance
                                      </template>

                                      <template #content>
                                          Are you sure you want to delete this record? Once the record is deleted, all of its resources and data will be permanently deleted. Please confirm you would like to permanently delete this record.
                                      </template>

                                      <template #footer>
                                          <jet-secondary-button @click="confirmingUserDeletion = false">
                                              Cancel
                                          </jet-secondary-button>

                                          <jet-danger-button class="ml-3" @click="deleteUser(attendance.id)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                              Delete Account
                                          </jet-danger-button>
                                      </template>
                                  </jet-dialog-modal>
                                  
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <div v-else>
                          <div v-if="$page.props.user.roles[0].name != 'parent'" class="bg-orange-500 px-12 py-6 shadow flex items-center space-x-4 text-white">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="exclamation-circle" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm">There are no Attendances currently in the system. Please add new using the button above</p>
                          </div>
                          <div v-if="$page.props.user.roles[0].name == 'parent'" class="bg-orange-500 px-12 py-6 shadow flex items-center space-x-4 text-white">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="exclamation-circle" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm">There are no Attendances currently in the system. Please admit your children to our facility</p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="showingModal">
            <div>
              <div class="header flex items-center justify-between bg-blue-500 px-12 py-5">
                <div class="flex items-center">
                  <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                  <h3 class="text-white text-lg">Add Attendance</h3>
                </div>
                <button @click="closedModal">
                  <svg class="w-5 h-5 text-gray-300 hover:text-white duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
              <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                  <div class="mt-5 md:mt-0 md:col-span-3">
                    <form>
                      <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                          <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                              <label for="caretaker_id" class="block text-sm font-medium text-gray-700">Caretaker</label>
                              <select id="caretaker_id" v-model="form.caretaker_id" name="caretaker_id" autocomplete="caretaker_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option v-for="caretaker in staff" :key="caretaker.id" :value="caretaker.id">{{ caretaker.name }}</option>
                              </select>
                              <jet-input-error :message="form.errors.caretaker_id" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="child_id" class="block text-sm font-medium text-gray-700">Child</label>
                              <select id="child_id" v-model="form.child_id" name="child_id" autocomplete="child_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option v-for="child in children" :key="child.id" :value="child.id">{{ child.first_name + ' ' + child.last_name }}</option>
                              </select>
                              <jet-input-error :message="form.errors.child_id" class="mt-2" />
                            </div>

                            <div class="col-span-6">
                              <label for="drop_off" class="block text-sm font-medium text-gray-700">Drop Off Time</label>
                              <input type="time" v-model="form.drop_off" name="drop_off" id="drop_off" autocomplete="drop_off" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.drop_off" class="mt-2" />
                            </div>

                          </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                          <button @click.prevent="submitForm" :disabled="form.processing" :class="{ 'opacity-25': form.processing }" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </Modal>
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
import { Link } from '@inertiajs/inertia-vue3'
import Modal from "@/Jetstream/Modal.vue"
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import axios from 'axios'

export default {
  name: 'Dashboard',
  props: ["attendances", 'children', 'staff', 'can'],
  components: {
    Sidebar,
    Header,
    WelcomeBanner,
    FilterButton,
    DashboardWidget,
    Banner,
    Link,
    Modal,
    JetInputError,
    JetSecondaryButton,
    JetDangerButton,
    JetDialogModal,
  },
  setup() {

    const sidebarOpen = ref(false)

    return {
      sidebarOpen,
    } 
  },
  data() {
    return {
      showingModal: false,
      confirmingUserDeletion: false,
      form: this.$inertia.form({
          caretaker_id: "",
          child_id: "",
          drop_off: "",
      }),
      timeNow: Date.now(),
    }
  },
  methods: {
    submitForm() {
      this.form.post('/'+ this.$page.props.user.roles[0].name +"/attendances/", {
          errorBag: 'updateAttendances',
          preserveScroll: true,
          onSuccess: () => (this.showingModal = false, this.form.reset()),
      });
      setTimeout(() => {
        this.$page.props.flash.message = null
      }, 3000);
    },
    deleteUser(id) {
      this.$inertia.delete("/attendance/delete/" + id , {
        onFinish: visit => this.confirmingUserDeletion = false
      });
      setTimeout(() => {
        this.$page.props.flash.message = null
      }, 3000);
    },
    closedModal() {
      this.showingModal = false
      this.form.reset();
    },
    markChildPicked(id){
      this.$inertia.patch('/'+ this.$page.props.user.roles[0].name +"/attendances/" + id, {
          pick_up: this.timeNow,
          errorBag: 'updateAttendances',
          preserveScroll: true,
      });
      setTimeout(() => {
        this.$page.props.flash.message = null
      }, 3000);
    }
  }
}
</script>