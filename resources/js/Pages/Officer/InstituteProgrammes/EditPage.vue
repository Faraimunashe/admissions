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
            <h1 class="text-3xl font-bold text-gray-900">Edit Programme Status</h1>
            <p class="text-gray-600 mt-2">Update the status of {{ instituteProgramme.programme?.name }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Programme Status</h2>
                        <p class="text-sm text-gray-600 mt-1">Update the programme status and availability</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form @submit.prevent="submit" class="p-8">
                <!-- Programme Info (Read-only) -->
                <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Programme Information</h3>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-lg font-semibold text-indigo-600">
                                {{ instituteProgramme.programme?.name?.charAt(0).toUpperCase() }}
                            </span>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ instituteProgramme.programme?.name }}</h4>
                            <p class="text-sm text-gray-600">Programme ID: {{ instituteProgramme.programme?.id }}</p>
                            <p class="text-sm text-gray-600">Linked to: {{ institute.name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Current Status Display -->
                <div class="mb-6 p-4 rounded-lg border" :class="instituteProgramme.active ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'">
                    <div class="flex items-center">
                        <div :class="[
                            'w-8 h-8 rounded-full flex items-center justify-center mr-3',
                            instituteProgramme.active ? 'bg-green-100' : 'bg-red-100'
                        ]">
                            <svg v-if="instituteProgramme.active" class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <svg v-else class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium" :class="instituteProgramme.active ? 'text-green-800' : 'text-red-800'">
                                Currently {{ instituteProgramme.active ? 'Active' : 'Inactive' }}
                            </p>
                            <p class="text-sm" :class="instituteProgramme.active ? 'text-green-600' : 'text-red-600'">
                                {{ instituteProgramme.active ? 'This programme can receive applications' : 'This programme cannot receive applications' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Active Status Toggle -->
                <div class="space-y-4 mb-6">
                    <label class="block text-sm font-semibold text-gray-700">
                        Programme Status
                    </label>

                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200" :class="form.active ? 'border-indigo-300 bg-indigo-50' : 'border-gray-300'">
                            <input
                                v-model="form.active"
                                type="radio"
                                :value="true"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                            />
                            <div class="ml-3">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900">Active</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Programme can receive applications from students</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200" :class="!form.active ? 'border-indigo-300 bg-indigo-50' : 'border-gray-300'">
                            <input
                                v-model="form.active"
                                type="radio"
                                :value="false"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                            />
                            <div class="ml-3">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center mr-2">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900">Inactive</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">Programme cannot receive applications from students</p>
                            </div>
                        </label>
                    </div>

                    <p v-if="form.errors.active" class="text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ form.errors.active }}
                    </p>
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
                        <span v-if="!form.processing">Update Status</span>
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
                <span class="text-green-800 text-sm font-medium">Programme status updated successfully</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

const props = defineProps({
    instituteProgramme: Object,
    institute: Object
})

const form = useForm({
    active: props.instituteProgramme.active,
})

const submit = () => {
    form.put(`/officer/institute-programmes/${props.instituteProgramme.id}`)
}
</script>

<script>
export default {
    layout: Layout
}
</script>
