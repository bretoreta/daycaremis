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

          <div class="grid grid-cols-6 gap-4">
            <div class="col-span-6 md:col-span-4">
                <div class="border border-gray-300 rounded-lg w-full px-8 py-5">
                    <h3 class="font-bold mb-4">Register Complaint</h3>
                    <form @submit.prevent="submit">
                      <div>
                        <jet-label for="brief_title" value="Brief Title" />
                        <jet-input id="brief_title" type="text" v-model="form.brief_title" class="mt-1 block w-full" required autofocus />
                        <jet-input-error :message="form.errors.brief_title" class="mt-2" />
                      </div>
                      <div class="mt-5">
                        <jet-label for="detailed_info" value="Tell us what you're not happy about" />
                        <textarea rows="5" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" 
                                  id="detailed_info" type="text" v-model="form.detailed_info" required>
                        </textarea>
                        <jet-input-error :message="form.errors.detailed_info" class="mt-2" />
                      </div>
                      <div class="mt-5 flex w-full items-center justify-end">
                        <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                          Register
                        </jet-button>
                      </div>
                    </form>
                </div>
            </div>
            <div class="col-span-6 md:col-span-2">
              <div class="border border-gray-300 rounded-lg shadow w-full px-8 py-5">
                  <h3 class="font-bold mb-4">Recent Complaints</h3>
                  <div v-for="complaint in complaints" :key="complaint.tracking_no">
                    <div class="rounded p-4 mb-4 bg-red-600">
                      <p class="text-xs text-red-900">{{ complaint.tracking_no }}</p>
                      <div>
                        <p class="uppercasr font-bold text-white">{{ complaint.brief_title }}</p>
                        <p class="text-sm text-red-300">{{ complaint.detailed_info }}</p>
                      </div>
                    </div>
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
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetInputError from '@/Jetstream/InputError.vue'

export default {
  name: 'Dashboard',
  props: ['complaints'],
  components: {
    Sidebar,
    Header,
    WelcomeBanner,
    FilterButton,
    DashboardWidget,
    Banner,
    JetInput,
    JetButton,
    JetLabel,
    JetInputError,
  },
  data() {
    return {
      form: this.$inertia.form({
        brief_title: '',
        detailed_info: '',
      })
    }
  },
  setup() {

    const sidebarOpen = ref(false)

    return {
      sidebarOpen,
    } 
  },
  methods: {
    submit() {
      this.form.post('/complaints', {
        onSuccess: () => (this.showingModal = false, this.form.reset()),
      });
      setTimeout(() => {
        this.$page.props.flash.message = null
      }, 3000);
    },

    selectNewPhoto() {
        this.$refs.photo.click();
    },

    updatePhotoPreview() {
        const photo = this.$refs.photo.files[0];

        if (! photo) return;

        const reader = new FileReader();

        reader.onload = (e) => {
            this.photoPreview = e.target.result;
        };

        reader.readAsDataURL(photo);
    },

    clearPhotoFileInput() {
        if (this.$refs.photo?.value) {
            this.$refs.photo.value = null;
        }
    },
  },
}
</script>