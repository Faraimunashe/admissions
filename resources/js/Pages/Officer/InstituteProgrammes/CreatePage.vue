<template>
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="/officer/institute-programmes" class="inline-flex items-center text-gray-600 hover:text-indigo-600 transition-colors duration-200 mr-4">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Institute Programmes
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Link Programme to Institute</h1>
            <p class="text-gray-600 mt-2">Add a new programme to {{ institute.name }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Programme Selection</h2>
                        <p class="text-sm text-gray-600 mt-1">Choose a programme to link to your institute</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form @submit.prevent="submit" class="p-8">
                <!-- Programme Selection -->
                <div class="space-y-2 mb-6">
                    <label for="programme_id" class="block text-sm font-semibold text-gray-700">
                        Programme <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <select
                            v-model="form.programme_id"
                            id="programme_id"
                            :class="[
                                'block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200',
                                form.errors.programme_id ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : ''
                            ]"
                            required
                        >
                            <option value="">Select a programme</option>
                            <option v-for="programme in programmes" :key="programme.id" :value="programme.id">
                                {{ programme.name }}
                            </option>
                        </select>
                    </div>
                    <p v-if="form.errors.programme_id" class="text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ form.errors.programme_id }}
                    </p>
                </div>

                <!-- Active Status -->
                <div class="space-y-2 mb-6">
                    <label class="flex items-center">
                        <input
                            v-model="form.active"
                            type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <span class="ml-2 text-sm text-gray-700">Make this programme active (available for applications)</span>
                    </label>
                    <p class="text-xs text-gray-500">Active programmes can receive applications from students</p>
                </div>

                <!-- Selected Programme Info -->
                <div v-if="selectedProgramme" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Selected Programme</h3>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-sm font-semibold text-indigo-600">
                                {{ selectedProgramme.name.charAt(0).toUpperCase() }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ selectedProgramme.name }}</p>
                            <p class="text-sm text-gray-600">Programme ID: {{ selectedProgramme.id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-200 mt-8">
                    <a href="/officer/institute-programmes" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg shadow-sm hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    >
                        <span v-if="!form.processing">Link Programme</span>
                        <span v-else class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Linking...
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
                <span class="text-green-800 text-sm font-medium">Programme linked successfully</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

const props = defineProps({
    programmes: Array,
    institute: Object
})

const form = useForm({
    programme_id: '',
    active: true,
})

const selectedProgramme = computed(() => {
    if (!form.programme_id) return null
    return props.programmes.find(p => p.id == form.programme_id)
})

const submit = () => {
    form.post('/officer/institute-programmes')
}
</script>

<script>
export default {
    layout: Layout
}
</script>
