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
                              <Link :href="route(`admin.meals.index`)">
                                <svg class="w-6 h-6 text-gray-500 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                              </Link>
                              <h3 class="text-3xl">{{ $page.props.meal.name }}</h3>
                            </div>
                            <button v-if="can.edit" @click="showingModal = true" class="bg-blue-500 text-white py-2 px-8 shadow rounded text-sm uppercase hover:bg-blue-600">Edit</button>
                        </div>

                        <!-- Meal's Details Go Here -->

                        <div class="bg-white border border-gray-300 overflow-hidden sm:rounded-lg">
                          <div class="px-4 py-5 sm:px-6">
                              <h3 class="text-lg leading-6 font-medium text-gray-900">Meal's Information</h3>
                              <p class="mt-1 max-w-2xl text-sm text-gray-500">Details for {{ $page.props.meal.name }}.</p>
                          </div>
                          <div class="border-t border-gray-200">
                              <dl>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Name</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.meal.name }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Breakfast</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.meal.breakfast }}</dd>
                              </div>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Lunch</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.meal.lunch }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Supper</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.meal.supper }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Special</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.meal.special ?? 'N/A' }}</dd>
                              </div>
                              </dl>
                          </div>
                        </div>
                        
                        <!-- Children Details Go Here -->
                        <div class="mt-4">
                          
                          <div class="bg-white border border-gray-300 overflow-hidden sm:rounded-lg">
                            <div class="flex items-center justify-between mr-5">
                              <div class="px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Children Information</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Children who have subscribed to {{ $page.props.meal.name }}.</p>
                              </div>
                            </div>
                            <div v-if="$page.props.meal.children.length < 1" class="bg-orange-500 px-12 py-6 shadow flex items-center space-x-4 text-white">
                              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="exclamation-circle" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                              <p class="text-sm">There are no Children currently associated with this Meal. Please add new from <span class="text-orange-800 hover:text-orange-900 font-semibold"><Link :href="`/admin/children`"> Children Page </Link></span></p>
                            </div>
                            <div v-else class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                              <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="child in $page.props.meal.children" :key="child.id" class="bg-white hover:bg-gray-50 duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <Link :href="`/admin/children/` + child.id">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900">{{ child.first_name + ' ' + child.last_name }}</div>
                                                </div>
                                            </Link>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" :class="{'bg-red-200 text-red-900': child.gender === 'Male', 'bg-green-200 text-green-900': child.gender === 'Female', 'bg-yellow-200 text-yelow-900': child.gender === 'Other'}">{{ child.gender }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $page.props.meal.name }}</td>
                                      
                                    </tr>
                                </tbody>
                              </table>
                            </div>
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
                  <h3 class="text-white text-lg">Edit Meal</h3>
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
                              <input type="text" v-model="form.name" name="first-name" id="first-name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="breakfast" class="block text-sm font-medium text-gray-700">Breakfast</label>
                              <input type="text" v-model="form.breakfast" name="breakfast" id="breakfast" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.breakfast" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="lunch" class="block text-sm font-medium text-gray-700">Lunch</label>
                              <input type="text" v-model="form.lunch" name="lunch" id="lunch" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.lunch" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="supper" class="block text-sm font-medium text-gray-700">Supper</label>
                              <input type="text" v-model="form.supper" name="supper" id="supper" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.supper" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="apecial" class="block text-sm font-medium text-gray-700">Special</label>
                              <input type="text" v-model="form.special" name="apecial" id="apecial" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.special" class="mt-2" />
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
      props: ["meal", "can"],
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
              name: this.meal.name,
              breakfast: this.meal.breakfast,
              lunch: this.meal.lunch,
              supper: this.meal.supper,
              special: this.meal.special,
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
          this.form.patch("/admin/meals/" + this.meal.id, {
              errorBag: 'updateMealInformation',
              preserveScroll: true,
              onSuccess: () => (this.showingModal = false),
          });
          setTimeout(() => {
            this.$page.props.flash.message = null
          }, 3000);
        },
        closedModal() {
          this.showingModal = false
          this.form.reset();
        },
      }
    }
</script>