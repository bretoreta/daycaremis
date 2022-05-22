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
                              <Link :href="route( $page.props.user.roles[0].name + `.children.index`)">
                                <svg class="w-6 h-6 text-gray-500 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                              </Link>
                              <h3 class="text-3xl">{{ $page.props.child.first_name + ' ' + $page.props.child.last_name }}</h3>
                            </div>
                            <button v-if="can.edit" @click="showingModal = true" class="bg-blue-500 text-white py-2 px-8 shadow rounded text-sm uppercase hover:bg-blue-600">Edit</button>
                        </div>

                        <div class="bg-white border border-gray-300 overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Child Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Details for {{ $page.props.child.first_name + ' ' + $page.props.child.last_name }}.</p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">First name</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.child.first_name }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Middle Name</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.child.middle_name }}</dd>
                              </div>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Last Name</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.child.last_name }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.child.gender }}</dd>
                              </div>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Date Of Birth</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.child.dob }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">{{ $page.props.child.parent.relation_to_child }}</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.child.parent.name }}</dd>
                              </div>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Meal</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.child.meal.name }}</dd>
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
                  <h3 class="text-white text-lg">Edit Child</h3>
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
                            <div class="col-span-6 sm:col-span-2">
                              <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                              <input type="text" v-model="form.first_name" name="first_name" id="first_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.first_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                              <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name <span class="text-xs text-gray-400">(Optional)</span></label>
                              <input type="text" v-model="form.middle_name" name="middle_name" id="middle_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.middle_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                              <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                              <input type="text" v-model="form.last_name" name="last_name" id="last_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.last_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                              <input type="date" v-model="form.dob" name="dob" id="dob" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form.errors.dob" class="mt-2" />
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

                            <div v-if="$page.props.user.roles[0].name !='parent'" class="col-span-6 sm:col-span-3">
                              <label for="user_id" class="block text-sm font-medium text-gray-700">Parent</label>
                              <select id="user_id" v-model="form.user_id" name="user_id" autocomplete="user_id" 
                                      class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option v-for="parent in $page.props.parents" :key="parent.id" :value="parent.id">{{ parent.name }}</option>
                              </select>
                              <jet-input-error :message="form.errors.user_id" class="mt-2" />
                            </div>

                            <div v-if="$page.props.user.roles[0].name !='parent'" class="col-span-6 sm:col-span-3">
                              <label for="meal_id" class="block text-sm font-medium text-gray-700">Meal Package</label>
                              <select id="meal_id" v-model="form.meal_id" name="meal_id" autocomplete="meal_id" 
                                      class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option v-for="meal in $page.props.meals" :key="meal.id" :value="meal.id">{{ meal.name }}</option>
                              </select>
                              <jet-input-error :message="form.errors.meal_id" class="mt-2" />
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
  import DashboardWidget from '@/Components/DashboardWidget.vue'
  import Banner from '@/Partials/Admin/Banner.vue'
  import { Link } from '@inertiajs/inertia-vue3'
  import Modal from "@/Jetstream/Modal.vue"
  import JetInputError from '@/Jetstream/InputError.vue'

    export default {
      name: 'Dashboard',
      props: ["child", 'can'],
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
              first_name: this.child.first_name,
              middle_name: this.child.middle_name,
              last_name: this.child.last_name,
              dob: this.child.dob,
              gender: this.child.gender,
              meal_id: this.child.meal_id,
              user_id: this.child.user_id,
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
          this.form.patch("/" + this.$page.props.user.roles[0].name + "/children/" + this.child.id, {
              errorBag: 'updateChildInformation',
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
        }
      }
    }
</script>