<template>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="/admin/applications" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition-colors duration-200 mr-4">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Applications
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Application</h1>
            <p class="text-gray-600 mt-2">Update application status and details</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Application Information</h2>
                        <p class="text-sm text-gray-600 mt-1">Update the application details below</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form @submit.prevent="submit" class="p-8">
                <!-- Applicant Info (Read-only) -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Applicant Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-medium text-gray-900">{{ application.applicant?.user?.name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium text-gray-900">{{ application.applicant?.user?.email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Full Name</p>
                            <p class="font-medium text-gray-900">
                                {{ application.applicant?.firstnames }} {{ application.applicant?.surname }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-medium text-gray-900">{{ application.applicant?.phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Application Status -->
                <div class="space-y-2 mb-6">
                    <label for="status" class="block text-sm font-semibold text-gray-700">
                        Application Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <select
                            v-model="form.status"
                            id="status"
                            :class="[
                                'block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200',
                                form.errors.status ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : ''
                            ]"
                            required
                        >
                            <option value="PENDING">Pending</option>
                            <option value="RESPONDED">Responded</option>
                        </select>
                    </div>
                    <p v-if="form.errors.status" class="text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ form.errors.status }}
                    </p>
                </div>

                <!-- Period -->
                <div class="space-y-2 mb-6">
                    <label for="period_id" class="block text-sm font-semibold text-gray-700">
                        Application Period <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <select
                            v-model="form.period_id"
                            id="period_id"
                            :class="[
                                'block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200',
                                form.errors.period_id ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : ''
                            ]"
                            required
                        >
                            <option value="">Select a period</option>
                            <option v-for="period in periods" :key="period.id" :value="period.id">
                                {{ period.name }}
                            </option>
                        </select>
                    </div>
                    <p v-if="form.errors.period_id" class="text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ form.errors.period_id }}
                    </p>
                </div>

                <!-- Programme Choices (Read-only) -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Programme Choices</h3>
                    <div v-if="application.programmes?.length" class="space-y-3">
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
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                Choice {{ programme.choice }}
                            </span>
                        </div>
                    </div>
                    <div v-else class="text-center py-8 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">No programme choices selected</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-200 mt-8">
                    <a href="/admin/applications" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-sm hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    >
                        <span v-if="!form.processing">Update Application</span>
                        <span v-else class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Updating...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Success Message -->
        <div v-if="form.wasSuccessful" class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-green-800 text-sm font-medium">Application updated successfully</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

const props = defineProps({
    application: Object,
    periods: Array
})

const form = useForm({
    status: props.application.status || 'PENDING',
    period_id: props.application.period_id || '',
})

const submit = () => {
    form.put(`/admin/applications/${props.application.id}`)
}
</script>

<script>
export default {
    layout: Layout
}
</script>
