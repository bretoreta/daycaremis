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
                        <div class="my-6 flex justify-between items-center pr-8">
                            <div class="flex items-center">
                              <Link :href="route(`admin.admins.index`)">
                                <svg class="w-6 h-6 text-gray-500 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                              </Link>
                              <img :src="$page.props.admin.profile_photo_url" :alt="$page.props.admin.name" class="w-20 h-20 object-cover rounded-full mr-4">
                              <h3 class="text-3xl">{{ $page.props.admin.name }}</h3>
                              <div v-if="$page.props.user.id == $page.props.admin.id" class="font-bold ml-4 text-gray-500">(Me)</div>
                            </div>
                            <button @click="showingModal = true" class="bg-blue-500 text-white py-2 px-8 shadow rounded text-sm uppercase hover:bg-blue-600">Edit</button>
                        </div>

                        <div class="bg-white border border-gray-300 overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details for the seleced user.</p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.admin.name }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.admin.gender }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email address</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.admin.email }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Physical Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.admin.address }}</dd>
                            </div>
                            </dl>
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
                  <svg class="w-6 h-6 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                  <h3 class="text-white text-lg">Edit Admin</h3>
                </div>
                <button @click="closedModal">
                  <svg class="w-4 h-4 text-blue-800 hover:text-white duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>
              <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                  <div class="mt-5 md:mt-0 md:col-span-3">
                    <form>
                      <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                          <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-6">
                              <label for="first-name" class="block text-sm font-medium text-gray-700">Name</label>
                              <input type="text" v-model="form.name" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                              <input type="text" v-model="form.email" name="email" id="email" autocomplete="email" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.email" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                              <select id="gender" v-model="form.gender" name="gender" autocomplete="gender" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                              </select>
                              <jet-input-error :message="form.errors.gender" class="mt-2" />
                            </div>

                            <div class="col-span-6">
                              <label for="street-address" class="block text-sm font-medium text-gray-700">Physical address</label>
                              <input type="text" v-model="form.address" name="street-address" id="street-address" autocomplete="street-address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.address" class="mt-2" />
                            </div>

                          </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                          <button @click.prevent="closedModal" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-red-800 bg-red-300 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mr-3 duration-200">Cancel</button>
                          <button @click.prevent="submitForm" :disabled="form.processing" :class="{ 'opacity-25': form.processing }" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 duration-200">Save</button>
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
  import DashboardWidget from '@/Components/DashboardWidget.vue'
  import Banner from '@/Partials/Admin/Banner.vue'
  import { Link } from '@inertiajs/inertia-vue3'
  import Modal from "@/Jetstream/Modal.vue"
  import JetInputError from '@/Jetstream/InputError.vue'

    export default {
      name: 'Dashboard',
      props: ["admin"],
      components: {
        Sidebar,
        Header,
        DashboardWidget,
        Banner,
        Link,
        Modal,
        JetInputError,
      },
      data() {
        return {
          showingModal: false,
          form: this.$inertia.form({
              _method: 'PUT',
              name: this.admin.name,
              email: this.admin.email,
              gender: this.admin.gender,
              address: this.admin.address,
          }),
        }
      },
      setup() {

        const sidebarOpen = ref(false)

        return {
          sidebarOpen,
        } 
      },
      methods: {
        submitForm() {
          this.form.patch("/admin/admins/" + this.admin.id, {
              errorBag: 'updateAdminInformation',
              preserveScroll: true,
              onSuccess: () => (this.showingModal = false),
          });
        },
        closedModal() {
          this.showingModal = false
          this.form.reset();
        }
      }
    }
</script>