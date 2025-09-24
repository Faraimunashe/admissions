<template>
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/officer/institute-programmes" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition-colors duration-200 mr-4">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Institute Programmes
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a :href="`/officer/institute-programmes/${instituteProgramme.id}/edit`" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Programme
                    </a>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ instituteProgramme.programme?.name }}</h1>
            <p class="text-gray-600 mt-2">Programme details and applications</p>
        </div>

        <!-- Programme Status -->
        <div class="mb-8">
            <div :class="[
                'inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium',
                instituteProgramme.active
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
            ]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path v-if="instituteProgramme.active" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Status: {{ instituteProgramme.active ? 'Active' : 'Inactive' }}
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Programme Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Programme Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Programme Information</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start space-x-6">
                            <!-- Programme Icon -->
                            <div class="w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xl">
                                    {{ instituteProgramme.programme?.name?.charAt(0).toUpperCase() }}
                                </span>
                            </div>

                            <!-- Details -->
                            <div class="flex-1">
                                <h4 class="text-xl font-semibold text-gray-900 mb-2">
                                    {{ instituteProgramme.programme?.name }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600">Programme ID</p>
                                        <p class="font-medium text-gray-900">{{ instituteProgramme.programme?.id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Institute</p>
                                        <p class="font-medium text-gray-900">{{ instituteProgramme.institute?.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Status</p>
                                        <p class="font-medium" :class="instituteProgramme.active ? 'text-green-600' : 'text-red-600'">
                                            {{ instituteProgramme.active ? 'Active' : 'Inactive' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Linked Date</p>
                                        <p class="font-medium text-gray-900">{{ formatDate(instituteProgramme.created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applications -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Applications</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="applications.length > 0" class="space-y-4">
                            <div v-for="application in applications" :key="application.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-semibold text-sm">
                                            {{ application.application?.applicant?.user?.name?.charAt(0).toUpperCase() || 'A' }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">
                                            {{ application.application?.applicant?.user?.name || 'Unknown Applicant' }}
                                        </h4>
                                        <p class="text-sm text-gray-600">{{ application.application?.applicant?.user?.email }}</p>
                                        <div class="flex items-center space-x-4 mt-1 text-xs text-gray-500">
                                            <span>Choice {{ application.choice }}</span>
                                            <span>•</span>
                                            <span>Applied: {{ formatDate(application.application?.created_at) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span :class="[
                                        'px-2 py-1 text-xs font-medium rounded-full',
                                        application.application?.status === 'PENDING'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-green-100 text-green-800'
                                    ]">
                                        {{ application.application?.status }}
                                    </span>
                                    <a :href="`/officer/applications/${application.application?.id}`" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        View →
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">No applications for this programme yet</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Programme Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Applications</span>
                            <span class="font-medium text-gray-900">{{ applications.length }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pending Applications</span>
                            <span class="font-medium text-gray-900">
                                {{ applications.filter(app => app.application?.status === 'PENDING').length }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Responded Applications</span>
                            <span class="font-medium text-gray-900">
                                {{ applications.filter(app => app.application?.status === 'RESPONDED').length }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a :href="`/officer/institute-programmes/${instituteProgramme.id}/edit`" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                            Edit Programme Status
                        </a>
                        <a href="/officer/institute-programmes" class="block w-full text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Back to Programmes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Layout from '@/Shared/Layout.vue'

defineProps({
    instituteProgramme: Object,
    applications: Array
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
