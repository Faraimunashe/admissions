<template>
    <div class="max-w-6xl mx-auto">
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
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/officer/applications" class="inline-flex items-center text-gray-600 hover:text-green-600 transition-colors duration-200 mr-4">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Applications
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <button v-if="application.status === 'PENDING'" @click="showAcceptModal = true" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Accept Application
                    </button>
                    <button v-if="application.status === 'PENDING'" @click="showRejectModal = true" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Reject Application
                    </button>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Application Details</h1>
            <p class="text-gray-600 mt-2">Review and manage application for {{ institute.name }}</p>
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
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Applicant Information</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start space-x-6">
                            <!-- Avatar -->
                            <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
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
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-sm font-semibold text-indigo-600">{{ programme.choice }}</span>
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
                                    <span class="px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full">
                                        Choice {{ programme.choice }}
                                    </span>
                                    <span v-if="isProgrammeOfferedByInstitute(programme.programme)" class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                        Offered by {{ institute.name }}
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
                                <a :href="document.url" target="_blank" class="text-green-600 hover:text-green-800 text-sm font-medium">
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
                                <p v-if="offer.offer_details" class="text-xs text-blue-500 mt-1">{{ offer.offer_details }}</p>
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

        <!-- Accept Modal -->
        <div v-if="showAcceptModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Accept Application</h3>
                            <p class="text-sm text-gray-600">Select the programme to accept</p>
                        </div>
                    </div>

                    <form @submit.prevent="acceptApplication">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Programme</label>
                            <select v-model="acceptForm.programme_id" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Select a programme</option>
                                <option v-for="programme in availableProgrammes" :key="programme.id" :value="programme.id">
                                    Choice {{ programme.choice }}: {{ programme.programme?.name }}
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <button @click="showAcceptModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" :disabled="acceptForm.processing" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span v-if="!acceptForm.processing">Accept Application</span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Accepting...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div v-if="showRejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Reject Application</h3>
                            <p class="text-sm text-gray-600">Select the programme and provide a reason</p>
                        </div>
                    </div>

                    <form @submit.prevent="rejectApplication">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Programme</label>
                            <select v-model="rejectForm.programme_id" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Select a programme</option>
                                <option v-for="programme in availableProgrammes" :key="programme.id" :value="programme.id">
                                    Choice {{ programme.choice }}: {{ programme.programme?.name }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                            <textarea v-model="rejectForm.reason" required rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Please provide a reason for rejection..."></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <button @click="showRejectModal = false" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" :disabled="rejectForm.processing" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span v-if="!rejectForm.processing">Reject Application</span>
                                <span v-else class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Rejecting...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

const props = defineProps({
    application: Object,
    institute: Object
})

const showAcceptModal = ref(false)
const showRejectModal = ref(false)

const acceptForm = useForm({
    programme_id: ''
})

const rejectForm = useForm({
    programme_id: '',
    reason: ''
})

const availableProgrammes = computed(() => {
    return props.application.programmes.filter(programme =>
        isProgrammeOfferedByInstitute(programme.programme)
    )
})

const isProgrammeOfferedByInstitute = (programme) => {
    if (!programme?.institutes) return false
    return programme.institutes.some(institute => institute.id === props.institute.id)
}

const acceptApplication = () => {
    acceptForm.post(`/officer/applications/${props.application.id}/accept`, {
        onSuccess: () => {
            showAcceptModal.value = false
            acceptForm.reset()
        }
    })
}

const rejectApplication = () => {
    rejectForm.post(`/officer/applications/${props.application.id}/reject`, {
        onSuccess: () => {
            showRejectModal.value = false
            rejectForm.reset()
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
