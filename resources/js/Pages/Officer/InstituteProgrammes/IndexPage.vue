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
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Institute Programmes</h2>
                            <p class="text-gray-600 mt-1">Manage programmes offered by {{ institute.name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Total Programmes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ instituteProgrammes.total }}</p>
                        </div>
                        <a href="/officer/institute-programmes/create" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg shadow-sm hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Programme
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programmes List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div v-if="instituteProgrammes.data.length > 0" class="divide-y divide-gray-200">
                <div v-for="instituteProgramme in instituteProgrammes.data" :key="instituteProgramme.id" class="p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Programme Icon -->
                            <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ instituteProgramme.programme?.name?.charAt(0).toUpperCase() || 'P' }}
                                </span>
                            </div>

                            <!-- Programme Info -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ instituteProgramme.programme?.name }}
                                    </h3>
                                    <span :class="[
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        instituteProgramme.active
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800'
                                    ]">
                                        {{ instituteProgramme.active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span>Linked: {{ formatDate(instituteProgramme.created_at) }}</span>
                                    <span>•</span>
                                    <span>Last Updated: {{ formatDate(instituteProgramme.updated_at) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2">
                            <a :href="`/officer/institute-programmes/${instituteProgramme.id}`" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            <a :href="`/officer/institute-programmes/${instituteProgramme.id}/edit`" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <button @click="confirmDelete(instituteProgramme)" class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12 px-6">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No programmes linked</h3>
                <p class="text-gray-500 mb-6">Start by linking programmes to your institute.</p>
                <a href="/officer/institute-programmes/create" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg shadow-sm hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Link Programme
                </a>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="instituteProgrammes.last_page > 1" class="mt-6">
            <Pagination :links="instituteProgrammes.links" />
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Remove Programme</h3>
                            <p class="text-sm text-gray-600">This action cannot be undone.</p>
                        </div>
                    </div>

                    <p class="text-gray-700 mb-6">
                        Are you sure you want to remove <strong>{{ instituteProgrammeToDelete?.programme?.name }}</strong> from your institute?
                        This will remove the programme from your institute's offerings.
                    </p>

                    <div class="flex items-center justify-end space-x-3">
                        <button @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            Cancel
                        </button>
                        <button @click="deleteInstituteProgramme" :disabled="deleting" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span v-if="!deleting">Remove Programme</span>
                            <span v-else class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Removing...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import Pagination from '@/Shared/Pagination.vue'

defineProps({
    instituteProgrammes: Object,
    institute: Object
})

const showDeleteModal = ref(false)
const instituteProgrammeToDelete = ref(null)
const deleting = ref(false)

const confirmDelete = (instituteProgramme) => {
    instituteProgrammeToDelete.value = instituteProgramme
    showDeleteModal.value = true
}

const deleteInstituteProgramme = () => {
    if (!instituteProgrammeToDelete.value) return

    deleting.value = true
    router.delete(`/officer/institute-programmes/${instituteProgrammeToDelete.value.id}`, {
        onFinish: () => {
            deleting.value = false
            showDeleteModal.value = false
            instituteProgrammeToDelete.value = null
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
