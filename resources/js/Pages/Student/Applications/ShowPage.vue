<template>
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/student/applications" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors duration-200 mr-4">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Applications
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <span :class="[
                        'px-4 py-2 text-sm font-medium rounded-full',
                        getStatusClass(application.status)
                    ]">
                        {{ application.status || 'PENDING' }}
                    </span>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ application.period?.description || 'Application Details' }}</h1>
            <p class="text-gray-600 mt-2">Submitted on {{ formatDate(application.created_at) }}</p>
        </div>

        <!-- Application Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Programme Choices -->
            <div class="lg:col-span-2">
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
                        <div class="space-y-4">
                            <div v-for="programme in application.programmes" :key="programme.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 bg-green-100 text-green-600 text-sm font-semibold rounded-full flex items-center justify-center mr-3">
                                        {{ programme.choice }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ programme.programme?.name || 'Unknown Programme' }}</p>
                                        <p class="text-sm text-gray-600">{{ getChoiceLabel(programme.choice) }} Choice</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <!-- Offer Status -->
                                    <span v-if="hasOffer(programme.programme_id)" class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                        Offered
                                    </span>
                                    <!-- Rejection Status -->
                                    <span v-else-if="hasRejection(programme.programme_id)" class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                        Rejected
                                    </span>
                                    <!-- Pending Status -->
                                    <span v-else class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                        Pending
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Status -->
            <div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Application Status</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Offers -->
                            <div v-if="application.offers?.length > 0" class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-green-800">{{ application.offers.length }} Offer(s)</span>
                                </div>
                                <p class="text-xs text-green-700">Congratulations! You have received offers.</p>
                            </div>

                            <!-- Rejections -->
                            <div v-if="application.rejections?.length > 0" class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-red-800">{{ application.rejections.length }} Rejection(s)</span>
                                </div>
                                <p class="text-xs text-red-700">Some programmes were not available.</p>
                            </div>

                            <!-- Acceptance -->
                            <div v-if="application.acceptance" class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-blue-800">Accepted</span>
                                </div>
                                <p class="text-xs text-blue-700">
                                    {{ application.acceptance.programme?.name }} at {{ application.acceptance.institute?.name }}
                                </p>
                            </div>

                            <!-- Pending -->
                            <div v-if="application.status === 'PENDING'" class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-yellow-800">Under Review</span>
                                </div>
                                <p class="text-xs text-yellow-700">Your application is being reviewed by admission officers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offers Section -->
        <div v-if="application.offers?.length > 0 && !application.acceptance" class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Your Offers</h3>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                            {{ application.offers.length }} {{ application.offers.length === 1 ? 'Offer' : 'Offers' }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div v-for="offer in application.offers" :key="offer.id" class="border border-green-200 rounded-lg p-6 bg-green-50">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ offer.programme?.name }}</h4>
                                    <p class="text-sm text-gray-600">{{ offer.institute?.name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ offer.institute?.address }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Choice {{ getChoiceNumber(offer.programme_id) }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <p>Offered on {{ formatDate(offer.created_at) }}</p>
                                </div>
                                <button
                                    @click="acceptOffer(offer)"
                                    :disabled="accepting"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span v-if="!accepting">Accept Offer</span>
                                    <span v-else class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Accepting...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Submitted Documents</h3>
                </div>
            </div>

            <div class="p-6">
                <div v-if="application.documents?.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="document in application.documents" :key="document.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ document.description }}</p>
                                <p class="text-sm text-gray-600">{{ getFileName(document.file_path) }}</p>
                            </div>
                        </div>
                        <a :href="document.url" target="_blank" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            View →
                        </a>
                    </div>
                </div>
                <div v-else class="text-center py-8">
                    <p class="text-gray-500">No documents uploaded</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

const props = defineProps({
    application: Object
})

const accepting = ref(false)

const getChoiceLabel = (choice) => {
    const labels = ['1st', '2nd', '3rd']
    return labels[choice - 1] || `${choice}th`
}

const getChoiceNumber = (programmeId) => {
    const programme = props.application.programmes.find(p => p.programme_id === programmeId)
    return programme ? programme.choice : '?'
}

const hasOffer = (programmeId) => {
    return props.application.offers?.some(offer => offer.programme_id === programmeId)
}

const hasRejection = (programmeId) => {
    return props.application.rejections?.some(rejection => rejection.programme_id === programmeId)
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

const getFileName = (filePath) => {
    return filePath.split('/').pop()
}

const acceptOffer = (offer) => {
    accepting.value = true

    router.post(`/student/applications/${props.application.id}/accept`, {
        programme_id: offer.programme_id,
        institute_id: offer.institute_id
    }, {
        onFinish: () => {
            accepting.value = false
        }
    })
}

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
