<template>
    <div>
        <!-- Flash Messages -->
        <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-green-800 text-sm font-medium">{{ $page.props.flash.success }}</span>
            </div>
        </div>

        <div v-if="$page.props.flash && $page.props.flash.error" class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-red-800 text-sm font-medium">{{ $page.props.flash.error }}</span>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Applications</h2>
                            <p class="text-gray-600 mt-1">Manage applications for {{ institute.name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Total Applications</p>
                            <p class="text-2xl font-bold text-gray-900">{{ applications.total }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form @submit.prevent="applyFilters" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Search by name or email..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        />
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select v-model="filters.status" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">All Statuses</option>
                        <option value="PENDING">Pending</option>
                        <option value="RESPONDED">Responded</option>
                    </select>
                </div>

                <!-- Period Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Period</label>
                    <select v-model="filters.period_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">All Periods</option>
                        <option v-for="period in periods" :key="period.id" :value="period.id">
                            {{ period.name }}
                        </option>
                    </select>
                </div>

                <!-- Programme Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Programme</label>
                    <select v-model="filters.programme_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">All Programmes</option>
                        <option v-for="programme in programmes" :key="programme.id" :value="programme.id">
                            {{ programme.name }}
                        </option>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                        Apply Filters
                    </button>
                    <button @click="clearFilters" type="button" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                        Clear
                    </button>
                </div>
            </form>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div v-if="applications.data.length > 0" class="divide-y divide-gray-200">
                <div v-for="application in applications.data" :key="application.id" class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Applicant Avatar -->
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ application.applicant?.user?.name?.charAt(0).toUpperCase() || 'A' }}
                                </span>
                            </div>

                            <!-- Application Info -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ application.applicant?.user?.name || 'Unknown Applicant' }}
                                    </h3>
                                    <span :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        application.status === 'PENDING'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-green-100 text-green-800'
                                    ]">
                                        {{ application.status }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ application.applicant?.user?.email }}
                                </p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>Period: {{ application.period?.name }}</span>
                                    <span>•</span>
                                    <span>Applied: {{ formatDate(application.created_at) }}</span>
                                    <span v-if="application.programmes?.length" class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        {{ application.programmes.length }} {{ application.programmes.length === 1 ? 'Choice' : 'Choices' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2">
                            <a :href="`/officer/applications/${application.id}`" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            <button v-if="application.status === 'PENDING'" @click="quickAccept(application)" class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Accept
                            </button>
                        </div>
                    </div>

                    <!-- Programme Choices -->
                    <div v-if="application.programmes?.length" class="mt-4 ml-16">
                        <div class="flex flex-wrap gap-2">
                            <span v-for="programme in application.programmes" :key="programme.id" class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                Choice {{ programme.choice }}: {{ programme.programme?.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12 px-6">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No applications found</h3>
                <p class="text-gray-500 mb-6">No applications match your current filters.</p>
                <button @click="clearFilters" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-sm hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                    Clear Filters
                </button>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="applications.last_page > 1" class="mt-6">
            <Pagination :links="applications.links" />
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import Pagination from '@/Shared/Pagination.vue'

defineProps({
    applications: Object,
    periods: Array,
    programmes: Array,
    institute: Object,
    filters: Object
})

const filters = reactive({
    search: '',
    status: '',
    period_id: '',
    programme_id: ''
})

const applyFilters = () => {
    router.get('/officer/applications', filters, {
        preserveState: true,
        replace: true
    })
}

const clearFilters = () => {
    filters.search = ''
    filters.status = ''
    filters.period_id = ''
    filters.programme_id = ''
    applyFilters()
}

const quickAccept = (application) => {
    // Get the first programme choice for this institute
    const programme = application.programmes.find(p => p.programme?.institutes?.some(i => i.id === institute.id))
    if (programme) {
        router.post(`/officer/applications/${application.id}/accept`, {
            programme_id: programme.programme_id
        })
    }
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
