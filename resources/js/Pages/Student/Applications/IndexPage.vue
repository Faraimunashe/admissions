<template>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
                    <p class="text-gray-600 mt-2">Track and manage your admission applications</p>
                </div>
                <a href="/student/dashboard" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Applications List -->
        <div v-if="applications.data.length > 0" class="space-y-6">
            <div v-for="application in applications.data" :key="application.id" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Application Header -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ application.period?.description || 'Unknown Period' }}</h3>
                                <p class="text-sm text-gray-600">Applied on {{ formatDate(application.created_at) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span :class="[
                                'px-3 py-1 text-sm font-medium rounded-full',
                                getStatusClass(application.status)
                            ]">
                                {{ application.status || 'PENDING' }}
                            </span>
                            <a :href="`/student/applications/${application.id}`" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Application Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Programmes -->
                        <div class="lg:col-span-2">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Programme Choices</h4>
                            <div class="space-y-2">
                                <div v-for="programme in application.programmes" :key="programme.id" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <span class="w-8 h-8 bg-green-100 text-green-600 text-sm font-semibold rounded-full flex items-center justify-center mr-3">
                                            {{ programme.choice }}
                                        </span>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ programme.programme?.name || 'Unknown Programme' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Summary -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Application Status</h4>
                            <div class="space-y-3">
                                <!-- Offers -->
                                <div v-if="application.offers?.length > 0" class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-green-800">{{ application.offers.length }} Offer(s)</span>
                                    </div>
                                    <p class="text-xs text-green-700">You have received offers!</p>
                                </div>

                                <!-- Rejections -->
                                <div v-if="application.rejections?.length > 0" class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-red-800">{{ application.rejections.length }} Rejection(s)</span>
                                    </div>
                                    <p class="text-xs text-red-700">Some programmes were not available</p>
                                </div>

                                <!-- Acceptance -->
                                <div v-if="application.acceptance" class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-green-800">Accepted</span>
                                        </div>
                                        <button
                                            @click="downloadAcceptanceLetter(application.id, application.acceptance.id)"
                                            class="inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download Letter
                                        </button>
                                    </div>
                                    <p class="text-xs text-green-700">{{ application.acceptance.programme?.name }} at {{ application.acceptance.institute?.name }}</p>
                                </div>

                                <!-- Pending -->
                                <div v-if="application.status === 'PENDING'" class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-yellow-800">Under Review</span>
                                    </div>
                                    <p class="text-xs text-yellow-700">Your application is being reviewed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="applications.last_page > 1" class="mt-8">
                <Pagination :links="applications.links" />
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No applications found</h3>
            <p class="text-gray-500 mb-6">You haven't submitted any applications yet.</p>
            <a href="/student/dashboard" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-sm hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Go to Dashboard
            </a>
        </div>
    </div>
</template>

<script setup>
import Layout from '@/Shared/Layout.vue'
import Pagination from '@/Shared/Pagination.vue'

defineProps({
    applications: Object
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const downloadAcceptanceLetter = (applicationId, acceptanceId = null) => {
    let url = `/student/applications/${applicationId}/acceptance-letter`
    if (acceptanceId) {
        url += `?acceptance_id=${acceptanceId}`
    }
    window.location.href = url
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
