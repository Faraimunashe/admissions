<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50">
        <Navbar :username="username" />

        <!-- Main Content Area -->
        <div class="pt-16">
            <!-- Page Header -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="py-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $page.props.title || 'Dashboard' }}</h1>
                                <p class="mt-1 text-sm text-gray-500">Manage your university admissions system</p>
                            </div>

                            <!-- Quick Actions -->
                            <div class="flex items-center space-x-3">
                                <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Quick Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <main class="flex-1">
                <div class="py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <slot />
                    </div>
                </div>
            </main>
        </div>

        <Footer />
    </div>
</template>

<script>
import Navbar from './Navbar.vue';
import Footer from './Footer.vue';

export default {
    components: {
        Footer, Navbar
    },
    computed: {
        username() {
            return this.$page.props.auth.user.name
        }
    }
}
</script>
