<template>
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/admin/periods" class="inline-flex items-center text-gray-600 hover:text-purple-600 transition-colors duration-200 mr-4">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Periods
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a :href="`/admin/periods/${period.id}/edit`" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Period
                    </a>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ period.description }}</h1>
            <p class="text-gray-600 mt-2">Period details and statistics</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <p :class="[
                            'text-lg font-bold',
                            isActivePeriod(period) ? 'text-green-600' :
                            isUpcomingPeriod(period) ? 'text-blue-600' :
                            'text-gray-600'
                        ]">
                            {{ getPeriodStatus(period) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Applications Count -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Applications</p>
                        <p class="text-2xl font-bold text-gray-900">{{ period.applications.length }}</p>
                    </div>
                </div>
            </div>

            <!-- Start Date -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Start Date</p>
                        <p class="text-lg font-bold text-gray-900">{{ formatDate(period.start_date) }}</p>
                    </div>
                </div>
            </div>

            <!-- End Date -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">End Date</p>
                        <p class="text-lg font-bold text-gray-900">{{ formatDate(period.end_date) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Period Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Period Information</h3>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-3">{{ period.description }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-3">{{ getDuration(period) }} days</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Created</label>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-3">{{ formatDate(period.created_at) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                        <p class="text-gray-900 bg-gray-50 rounded-lg p-3">{{ formatDate(period.updated_at) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Applications in this Period</h3>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                        {{ period.applications.length }} {{ period.applications.length === 1 ? 'Application' : 'Applications' }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div v-if="period.applications.length > 0" class="space-y-4">
                    <div v-for="application in period.applications" :key="application.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-sm font-semibold text-green-600">
                                    {{ application.applicant?.user?.name?.charAt(0).toUpperCase() || 'A' }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ application.applicant?.user?.name || 'Unknown Applicant' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ application.applicant?.user?.email || 'No email' }}
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
                            <a :href="`/admin/applications/${application.id}`" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
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
                    <p class="text-gray-500">Applications will appear here once students start applying during this period.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Layout from '@/Shared/Layout.vue'

defineProps({
    period: Object
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}

const isActivePeriod = (period) => {
    const now = new Date()
    const startDate = new Date(period.start_date)
    const endDate = new Date(period.end_date)
    return now >= startDate && now <= endDate
}

const isUpcomingPeriod = (period) => {
    const now = new Date()
    const startDate = new Date(period.start_date)
    return now < startDate
}

const getPeriodStatus = (period) => {
    if (isActivePeriod(period)) return 'Active'
    if (isUpcomingPeriod(period)) return 'Upcoming'
    return 'Ended'
}

const getDuration = (period) => {
    const startDate = new Date(period.start_date)
    const endDate = new Date(period.end_date)
    const diffTime = Math.abs(endDate - startDate)
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
    return diffDays
}

const getStatusClass = (status) => {
    switch (status?.toLowerCase()) {
        case 'accepted':
            return 'bg-green-100 text-green-800'
        case 'rejected':
            return 'bg-red-100 text-red-800'
        case 'pending':
            return 'bg-yellow-100 text-yellow-800'
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
