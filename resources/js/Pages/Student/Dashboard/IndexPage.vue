<template>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Student Dashboard</h1>
            <p class="text-gray-600 mt-2">Welcome back! Here's an overview of your applications.</p>
        </div>

        <!-- Active Period Alert -->
        <div v-if="activePeriod" class="mb-8">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-green-900">{{ activePeriod.description }}</h3>
                            <p class="text-green-700 mt-1">
                                Application period: {{ formatDate(activePeriod.start_date) }} - {{ formatDate(activePeriod.end_date) }}
                            </p>
                        </div>
                    </div>
                    <div v-if="canApply" class="flex items-center space-x-3">
                        <a href="/student/applications/create" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-sm hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Apply Now
                        </a>
                    </div>
                    <div v-else class="flex items-center">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                            Application Submitted
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Active Period -->
        <div v-else class="mb-8">
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">No Active Application Period</h3>
                        <p class="text-gray-700 mt-1">There are currently no open admission periods. Check back later for new opportunities.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Applications -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Applications</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.total_applications }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending Review</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.pending_applications }}</p>
                    </div>
                </div>
            </div>

            <!-- Responded Applications -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Responded</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.responded_applications }}</p>
                    </div>
                </div>
            </div>

            <!-- Accepted Offers -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Accepted Offers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.accepted_offers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
                    </div>
                    <a href="/student/applications" class="text-green-600 hover:text-green-800 text-sm font-medium">
                        View All →
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div v-if="applications.length > 0" class="space-y-4">
                    <div v-for="application in applications" :key="application.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-sm font-semibold text-green-600">
                                    {{ application.period?.description?.charAt(0).toUpperCase() || 'A' }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ application.period?.description || 'Unknown Period' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ application.programmes?.length || 0 }} programmes • {{ formatDate(application.created_at) }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span :class="[
                                'px-3 py-1 text-xs font-medium rounded-full',
                                getStatusClass(application.status)
                            ]">
                                {{ application.status || 'PENDING' }}
                            </span>
                            <a :href="`/student/applications/${application.id}`" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                View →
                            </a>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-12">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No applications yet</h3>
                    <p class="text-gray-500 mb-6">Start your academic journey by submitting your first application.</p>
                    <a v-if="canApply && activePeriod" href="/student/applications/create" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-sm hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Application
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Layout from '@/Shared/Layout.vue'

defineProps({
    activePeriod: Object,
    applications: Array,
    canApply: Boolean,
    stats: Object
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const getStatusClass = (status) => {
    switch (status?.toLowerCase()) {
        case 'pending':
            return 'bg-yellow-100 text-yellow-800'
        case 'responded':
            return 'bg-blue-100 text-blue-800'
        case 'accepted':
            return 'bg-green-100 text-green-800'
        case 'rejected':
            return 'bg-red-100 text-red-800'
        default:
            return 'bg-gray-100 text-gray-800'
    }
}
</script>

<script>
export default {
    layout: Layout
}
</script>
