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
                              <Link :href="route($page.props.user.roles[0].name + `.parents.index`)">
                                <svg class="w-6 h-6 text-gray-500 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                              </Link>
                              <img :src="$page.props.parent.profile_photo_url" :alt="$page.props.parent.name" class="w-20 h-20 object-cover rounded-full mr-4">
                              <h3 class="text-3xl">{{ $page.props.parent.name }}</h3>
                              <div v-if="$page.props.user.id == $page.props.parent.id" class="font-bold ml-4 text-gray-500">(Me)</div>
                            </div>
                            <button v-if="can.edit" @click="showingModal = true" class="bg-blue-500 text-white py-2 px-8 shadow rounded text-sm uppercase hover:bg-blue-600">Edit</button>
                        </div>

                        <!-- Parent's Details Go Here -->

                        <div class="bg-white border border-gray-300 overflow-hidden sm:rounded-lg">
                          <div class="px-4 py-5 sm:px-6">
                              <h3 class="text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
                              <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details for {{ $page.props.parent.name }}.</p>
                          </div>
                          <div class="border-t border-gray-200">
                              <dl>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.parent.name }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.parent.gender }}</dd>
                              </div>
                              <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Email address</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.parent.email }}</dd>
                              </div>
                              <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                  <dt class="text-sm font-medium text-gray-500">Physical Address</dt>
                                  <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $page.props.parent.address }}</dd>
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
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Child details for {{ $page.props.parent.name }}.</p>
                              </div>
                              <button v-if="can.child.add" @click="addingChild = true" class="bg-blue-500 text-white py-2 px-8 shadow rounded text-sm uppercase hover:bg-blue-600">Add</button>
                            </div>
                            <div v-if="$page.props.parent.children.length < 1" class="bg-orange-500 px-12 py-6 shadow flex items-center space-x-4 text-white">
                              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" id="exclamation-circle" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                              <p class="text-sm">There are no Children currently associated with this parent. Please add new using the button above</p>
                            </div>
                            <div v-else class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                              <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Meal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="child in $page.props.parent.children" :key="child.id" class="bg-white hover:bg-gray-50 duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <Link :href="'/'+ $page.props.user.roles[0].name + `/children/` + child.id">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900">{{ child.first_name + ' ' + child.last_name }}</div>
                                                </div>
                                            </Link>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" :class="{'bg-red-200 text-red-900': child.gender === 'Male', 'bg-green-200 text-green-900': child.gender === 'Female', 'bg-yellow-200 text-yelow-900': child.gender === 'Other'}">{{ child.gender }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ child.meal.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                          <div v-if="! child.attendances.length < 1">
                                            <span v-if="child.attendances[0].pick_up" class="text-green-800 px-3 py-1 bg-green-200 rounded-full">Picked Up</span>
                                            <span v-else class="text-yellow-800 px-3 py-1 bg-yellow-200 rounded-full">In Care</span>
                                          </div>
                                          <div v-else>
                                            <span class="text-gray-900 px-3 py-1 bg-gray-200 rounded-full">Not In Care</span>
                                          </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center justify-center">
                                            <Link v-if="can.child.read" :href="'/'+ $page.props.user.roles[0].name + `/children/` + child.id" class="text-indigo-600 hover:text-indigo-900 mr-5 flex items-center">
                                              <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                              View
                                            </Link>
                                            <button v-if="can.child.delete" @click="confirmingChildDeletion = true" class="text-red-600 hover:text-red-900 flex items-center">
                                              <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                              Delete
                                            </button>
                                        </td>

                                        <jet-dialog-modal :show="confirmingChildDeletion">
                                          <template #title>
                                              Delete Child
                                          </template>

                                          <template #content>
                                              Are you sure you want to delete this record? Once the record is deleted, all of its resources and data will be permanently deleted. Please confirm you would like to permanently delete this record.
                                          </template>

                                          <template #footer>
                                              <jet-secondary-button @click="confirmingChildDeletion = false">
                                                  Cancel
                                              </jet-secondary-button>

                                              <jet-danger-button class="ml-3" @click="deleteUser2(child.id)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                  Delete Account
                                              </jet-danger-button>
                                          </template>
                                      </jet-dialog-modal>
                                      
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
                  <h3 class="text-white text-lg">Edit Parent</h3>
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

                            <div class="col-span-6 sm:col-span-3">
                              <label for="relation_to_child" class="block text-sm font-medium text-gray-700">Relation to Child</label>
                              <select id="relation_to_child" v-model="form.relation_to_child" name="relation_to_child" autocomplete="relation_to_child" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="Mother">Mother</option>
                                <option value="Female">Father</option>
                                <option value="Guardian">Guardian</option>
                              </select>
                              <jet-input-error :message="form.errors.relation_to_child" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
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
        <Modal :show="addingChild">
            <div>
              <div class="header flex items-center justify-between bg-blue-500 px-12 py-5">
                <div class="flex items-center">
                  <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                  <h3 class="text-white text-lg">Add Child</h3>
                </div>
                <button @click="closedModal2">
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
                            <div class="col-span-6 sm:col-span-2">
                              <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                              <input type="text" v-model="form2.first_name" name="first_name" id="first_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form2.errors.first_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                              <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name <span class="text-xs text-gray-400">(Optional)</span></label>
                              <input type="text" v-model="form2.middle_name" name="middle_name" id="middle_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form2.errors.middle_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                              <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                              <input type="text" v-model="form2.last_name" name="last_name" id="last_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form2.errors.last_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                              <input type="date" v-model="form2.dob" name="dob" id="dob" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                              <jet-input-error :message="form2.errors.dob" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                              <select id="gender" v-model="form2.gender" name="gender" autocomplete="gender" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                              </select>
                              <jet-input-error :message="form2.errors.gender" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="user_id" class="block text-sm font-medium text-gray-700">Parent</label>
                              <select id="user_id" v-model="form2.user_id" name="user_id" autocomplete="user_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" disabled>
                                <option v-for="parent in $page.props.parents" :key="parent.id" :value="parent.id">{{ parent.name }}</option>
                              </select>
                              <jet-input-error :message="form2.errors.user_id" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                              <label for="meal_id" class="block text-sm font-medium text-gray-700">Meal Package</label>
                              <select id="meal_id" v-model="form2.meal_id" name="meal_id" autocomplete="meal_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option v-for="meal in $page.props.meals" :key="meal.id" :value="meal.id">{{ meal.name }}</option>
                              </select>
                              <jet-input-error :message="form2.errors.meal_id" class="mt-2" />
                            </div>

                          </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                          <button @click.prevent="submitForm2" :disabled="form2.processing" :class="{ 'opacity-25': form2.processing }" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save</button>
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
      props: ["parent", 'can'],
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
          addingChild: false,
          confirmingChildDeletion: false,
          form: this.$inertia.form({
              name: this.parent.name,
              email: this.parent.email,
              gender: this.parent.gender,
              relation_to_child: this.parent.relation_to_child,
              address: this.parent.address,
          }),
          form2: this.$inertia.form({
              first_name: "",
              middle_name: "",
              last_name: "",
              dob: "",
              gender: "",
              meal_id: "",
              user_id: this.parent.id,
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
          this.form.patch("/" + this.$page.props.user.roles[0].name + "/parents/" + this.parent.id, {
              errorBag: 'updateAdminInformation',
              preserveScroll: true,
              onSuccess: () => (this.showingModal = false),
          });
          setTimeout(() => {
            this.$page.props.flash.message = null
          }, 3000);
        },
        submitForm2() {
          this.form2.post("/" + this.$page.props.user.roles[0].name + "/children", {
              errorBag: 'updateChildInformation',
              preserveScroll: true,
              onSuccess: () => (this.addingChild = false, this.form2.reset()),
          });
          setTimeout(() => {
            this.$page.props.flash.message = null
          }, 3000);
        },
        deleteChild(id) {
          this.$inertia.delete("/child/delete/" + id , {
            onFinish: visit => this.confirmingChildDeletion = false
          });
          setTimeout(() => {
            this.$page.props.flash.message = null
          }, 3000);
        },
        closedModal() {
          this.showingModal = false
          this.form.reset();
        },
        closedModal2() {
          this.addingChild = false
          this.form2.reset();
        }
      }
    }
</script>