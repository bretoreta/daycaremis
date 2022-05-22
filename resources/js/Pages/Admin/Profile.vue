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
            <div>
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                        <update-profile-information-form :user="$page.props.user" />

                        <jet-section-border />
                    </div>

                    <div v-if="$page.props.jetstream.canUpdatePassword">
                        <update-password-form class="mt-10 sm:mt-0" />

                        <jet-section-border />
                    </div>

                    <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                        <two-factor-authentication-form class="mt-10 sm:mt-0" />

                        <jet-section-border />
                    </div>

                    <logout-other-browser-sessions-form :sessions="sessions" class="mt-10 sm:mt-0" />

                    <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                        <jet-section-border />

                        <delete-user-form class="mt-10 sm:mt-0" />
                    </template>
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
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
    import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue'
    import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue'
    import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue'
    import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'
    import Sidebar from '@/Partials/Admin/Sidebar.vue'
    import Header from '@/Partials/Admin/Header.vue'
    import WelcomeBanner from '@/Partials/Admin/dashboard/WelcomeBanner.vue'
    import FilterButton from '@/Components/DropdownFilter.vue'
    import DashboardWidget from '@/Components/DashboardWidget.vue'
    import Banner from '@/Partials/Admin/Banner.vue'

    export default defineComponent({
        props: ['sessions'],

        components: {
            AppLayout,
            DeleteUserForm,
            JetSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
            Sidebar,
            Header,
            WelcomeBanner,
            FilterButton,
            DashboardWidget,
            Banner,
        },
        setup() {

            const sidebarOpen = ref(false)

            return {
            sidebarOpen,
            } 
        }
    })
</script>
