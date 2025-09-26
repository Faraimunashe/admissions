<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50">
        <Navbar :username="username" :role="role" />

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
        },
        role() {
            return this.$page.props.auth.role.name
        }
    }
}
</script>
