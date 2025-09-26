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
        <div v-if="offersWithInstitutes?.length > 0 && !application.acceptance" class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Your Programme Offers</h3>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                            {{ offersWithInstitutes.length }} {{ offersWithInstitutes.length === 1 ? 'Programme' : 'Programmes' }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-8">
                        <div v-for="offerGroup in offersWithInstitutes" :key="offerGroup.programme.id" class="border border-green-200 rounded-lg p-6 bg-green-50">
                            <!-- Programme Header -->
                            <div class="mb-6">
                                <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ offerGroup.programme.name }}</h4>
                                <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                                    Choice {{ getChoiceNumber(offerGroup.programme.id) }}
                                </span>
                                <p class="text-sm text-gray-600 mt-2">
                                    You have received offers from {{ offerGroup.institutes.length }}
                                    {{ offerGroup.institutes.length === 1 ? 'institute' : 'institutes' }} for this programme.
                                    Choose your preferred institute below.
                                </p>
                            </div>

                            <!-- Institute Options -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div v-for="institute in offerGroup.institutes" :key="institute.id"
                                     class="border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition-shadow">
                                    <div class="flex items-start space-x-4">
                                        <!-- Institute Logo -->
                                        <div class="flex-shrink-0">
                                            <div v-if="institute.logo" class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                                <img :src="`/storage/${institute.logo}`"
                                                     :alt="institute.name + ' Logo'"
                                                     class="w-full h-full object-contain">
                                            </div>
                                            <div v-else class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Institute Details -->
                                        <div class="flex-1 min-w-0">
                                            <h5 class="text-lg font-semibold text-gray-900 mb-1">{{ institute.name }}</h5>

                                            <div class="space-y-1 text-sm text-gray-600">
                                                <div v-if="institute.address" class="flex items-start">
                                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    {{ institute.address }}
                                                </div>

                                                <div v-if="institute.phone" class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    {{ institute.phone }}
                                                </div>

                                                <div v-if="institute.web" class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                                    </svg>
                                                    <a :href="institute.web" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                        {{ institute.web }}
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Offer Details -->
                                            <div v-if="institute.offer_details" class="mt-3 p-3 bg-blue-50 rounded-lg">
                                                <p class="text-sm text-blue-800">
                                                    <strong>Offer Details:</strong> {{ institute.offer_details }}
                                                </p>
                                            </div>

                                            <!-- Offer Date -->
                                            <div class="mt-2 text-xs text-gray-500">
                                                Offered on {{ formatDate(institute.created_at) }}
                                            </div>
                                        </div>

                                        <!-- Accept Button -->
                                        <div class="flex-shrink-0">
                                            <button
                                                @click="acceptOffer(offerGroup.programme.id, institute.id)"
                                                :disabled="accepting"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                            >
                                                <span v-if="!accepting">Choose This Institute</span>
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
                </div>
            </div>
        </div>

        <!-- Acceptance Section -->
        <div v-if="application.acceptances?.length > 0" class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Your Accepted Offers</h3>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                            {{ application.acceptances.length }} {{ application.acceptances.length === 1 ? 'Acceptance' : 'Acceptances' }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Quick Download Button -->
                    <div v-if="application.acceptances?.length" class="mb-6 text-center">
                        <button
                            @click="downloadAcceptanceLetter(application.acceptances[0].id)"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold text-lg rounded-xl hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-xl transform hover:scale-105"
                        >
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            📄 Download Your Acceptance Letter
                        </button>
                        <p class="text-sm text-gray-600 mt-2">Click to download your official acceptance letter</p>
                    </div>

                    <div class="space-y-4">
                        <div v-for="acceptance in application.acceptances" :key="acceptance.id" class="border border-blue-200 rounded-lg p-6 bg-blue-50">
                            <div class="flex items-start space-x-4">
                                <!-- Institute Logo -->
                                <div class="flex-shrink-0">
                                    <div v-if="acceptance.institute?.logo" class="w-16 h-16 rounded-lg overflow-hidden bg-white">
                                        <img :src="`/storage/${acceptance.institute.logo}`"
                                             :alt="acceptance.institute.name + ' Logo'"
                                             class="w-full h-full object-contain">
                                    </div>
                                    <div v-else class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Acceptance Details -->
                                <div class="flex-1">
                                    <h4 class="text-xl font-semibold text-gray-900 mb-2">
                                        {{ acceptance.programme?.name }}
                                    </h4>
                                    <p class="text-lg text-gray-700 mb-3">
                                        {{ acceptance.institute?.name }}
                                    </p>

                                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                                        <div v-if="acceptance.institute?.address" class="flex items-start">
                                            <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ acceptance.institute.address }}
                                        </div>

                                        <div v-if="acceptance.institute?.phone" class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ acceptance.institute.phone }}
                                        </div>

                                        <div v-if="acceptance.institute?.web" class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                            </svg>
                                            <a :href="acceptance.institute.web" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                {{ acceptance.institute.web }}
                                            </a>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-600">
                                            <p>Accepted on {{ formatDate(acceptance.created_at) }}</p>
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                Choice {{ getChoiceNumber(acceptance.programme_id) }}
                                            </span>
                                        </div>

                                        <button
                                            @click="downloadAcceptanceLetter(acceptance.id)"
                                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg transform hover:scale-105"
                                        >
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download Acceptance Letter
                                        </button>
                                    </div>
                                </div>
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
    application: Object,
    offersWithInstitutes: Array
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

const acceptOffer = (programmeId, instituteId) => {
    accepting.value = true

    router.post(`/student/applications/${props.application.id}/accept`, {
        programme_id: programmeId,
        institute_id: instituteId
    }, {
        onFinish: () => {
            accepting.value = false
        }
    })
}

const downloadAcceptanceLetter = (acceptanceId = null) => {
    let url = `/student/applications/${props.application.id}/acceptance-letter`
    if (acceptanceId) {
        url += `?acceptance_id=${acceptanceId}`
    }
    window.location.href = url
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
