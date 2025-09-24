<template>
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/admin/applications" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors duration-200 mr-4">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Applications
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a :href="`/admin/applications/${application.id}/edit`" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Application
                    </a>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Application Details</h1>
            <p class="text-gray-600 mt-2">View and manage application information</p>
        </div>

        <!-- Application Status -->
        <div class="mb-8">
            <div :class="[
                'inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium',
                application.status === 'PENDING'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-green-100 text-green-800'
            ]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path v-if="application.status === 'PENDING'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Status: {{ application.status }}
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Applicant Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Applicant Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Applicant Information</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start space-x-6">
                            <!-- Avatar -->
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xl">
                                    {{ application.applicant?.user?.name?.charAt(0).toUpperCase() || 'A' }}
                                </span>
                            </div>

                            <!-- Details -->
                            <div class="flex-1">
                                <h4 class="text-xl font-semibold text-gray-900 mb-2">
                                    {{ application.applicant?.user?.name || 'Unknown Applicant' }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600">Email</p>
                                        <p class="font-medium text-gray-900">{{ application.applicant?.user?.email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Title</p>
                                        <p class="font-medium text-gray-900">{{ application.applicant?.title || 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Full Name</p>
                                        <p class="font-medium text-gray-900">
                                            {{ application.applicant?.firstnames }} {{ application.applicant?.surname }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Gender</p>
                                        <p class="font-medium text-gray-900">{{ application.applicant?.gender || 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Phone</p>
                                        <p class="font-medium text-gray-900">{{ application.applicant?.phone || 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Date of Birth</p>
                                        <p class="font-medium text-gray-900">
                                            {{ application.applicant?.dob ? formatDate(application.applicant.dob) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-600">Address</p>
                                    <p class="font-medium text-gray-900">{{ application.applicant?.address || 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Programme Choices -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Programme Choices</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="application.programmes?.length" class="space-y-4">
                            <div v-for="programme in application.programmes" :key="programme.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-sm font-semibold text-green-600">{{ programme.choice }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ programme.programme?.name }}</p>
                                        <p class="text-sm text-gray-600">
                                            Offered by {{ programme.programme?.institutes?.length || 0 }}
                                            {{ programme.programme?.institutes?.length === 1 ? 'institute' : 'institutes' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        Choice {{ programme.choice }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">No programme choices selected</p>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-violet-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Supporting Documents</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="application.documents?.length" class="space-y-3">
                            <div v-for="document in application.documents" :key="document.id" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ document.document_type }}</p>
                                        <p class="text-sm text-gray-600">{{ document.filename }}</p>
                                    </div>
                                </div>
                                <a :href="document.url" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View →
                                </a>
                            </div>
                        </div>
                        <div v-else class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">No supporting documents uploaded</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Application Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Application Details</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Application ID</p>
                            <p class="font-medium text-gray-900">#{{ application.id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Period</p>
                            <p class="font-medium text-gray-900">{{ application.period?.name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Applied Date</p>
                            <p class="font-medium text-gray-900">{{ formatDate(application.created_at) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Last Updated</p>
                            <p class="font-medium text-gray-900">{{ formatDate(application.updated_at) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Decisions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Decisions</h3>

                    <!-- Acceptance -->
                    <div v-if="application.acceptance" class="mb-4 p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium text-green-800">Accepted</span>
                        </div>
                        <p class="text-sm text-green-700">
                            {{ application.acceptance.programme?.name }} at {{ application.acceptance.institute?.name }}
                        </p>
                    </div>

                    <!-- Offers -->
                    <div v-if="application.offers?.length" class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Offers</h4>
                        <div class="space-y-2">
                            <div v-for="offer in application.offers" :key="offer.id" class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <p class="text-sm font-medium text-blue-800">{{ offer.programme?.name }}</p>
                                <p class="text-xs text-blue-600">{{ offer.institute?.name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rejections -->
                    <div v-if="application.rejections?.length" class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Rejections</h4>
                        <div class="space-y-2">
                            <div v-for="rejection in application.rejections" :key="rejection.id" class="p-3 bg-red-50 rounded-lg border border-red-200">
                                <p class="text-sm font-medium text-red-800">{{ rejection.programme?.name }}</p>
                                <p class="text-xs text-red-600">{{ rejection.institute?.name }}</p>
                                <p class="text-xs text-red-500 mt-1">{{ rejection.reason }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="!application.acceptance && !application.offers?.length && !application.rejections?.length" class="text-center py-4">
                        <p class="text-gray-500 text-sm">No decisions made yet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Layout from '@/Shared/Layout.vue'

defineProps({
    application: Object
})

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
}
</script>

<script>
export default {
    layout: Layout
}
</script>
