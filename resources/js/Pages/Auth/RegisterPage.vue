<template>
    <Head title="Register" />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-sky-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-pattern opacity-3"></div>

        <!-- Main Container -->
        <div class="max-w-2xl w-full space-y-8 relative z-10">
            <!-- Logo Section -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur-lg opacity-75 animate-pulse"></div>
                        <a href="/" class="relative bg-white rounded-2xl p-4 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <img src="../../../assets/images/logo.jpg" alt="Company Logo" class="w-16 h-16 rounded-xl">
                        </a>
                    </div>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                    Universities Admission System
                </h1>
                <p class="mt-2 text-gray-600 text-sm">Create your account to start your application journey</p>
            </div>

            <!-- Success Message -->
            <div v-if="form.wasSuccessful" class="bg-green-50 border border-green-200 rounded-xl p-4">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 text-sm font-medium">User created successfully</span>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 p-8 transition-all duration-300 hover:shadow-2xl">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Personal Information Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>

                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- First Names -->
                            <div class="space-y-2">
                                <label for="firstnames" class="block text-sm font-semibold text-gray-700">
                                    First Names *
                                </label>
                                <input
                                    v-model="form.firstnames"
                                    type="text"
                                    id="firstnames"
                                    placeholder="Enter your first names"
                                    :class="[
                                        'w-full px-4 py-3 border rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.firstnames ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                                <div v-if="form.errors.firstnames" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ form.errors.firstnames }}</span>
                                </div>
                            </div>

                            <!-- Surname -->
                            <div class="space-y-2">
                                <label for="surname" class="block text-sm font-semibold text-gray-700">
                                    Surname *
                                </label>
                                <input
                                    v-model="form.surname"
                                    type="text"
                                    id="surname"
                                    placeholder="Enter your surname"
                                    :class="[
                                        'w-full px-4 py-3 border rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.surname ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                                <div v-if="form.errors.surname" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ form.errors.surname }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Title and Gender -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <!-- Title -->
                            <div class="space-y-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700">
                                    Title *
                                </label>
                                <select
                                    v-model="form.title"
                                    id="title"
                                    :class="[
                                        'w-full px-4 py-3 border rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.title ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                                    <option value="">Select your title</option>
                                    <option value="Mr">Mr</option>
                                    <option value="Ms">Ms</option>
                                    <option value="Mrs">Mrs</option>
                                    <option value="Dr">Dr</option>
                                    <option value="Prof">Prof</option>
                                </select>
                                <div v-if="form.errors.title" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ form.errors.title }}</span>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="space-y-2">
                                <label for="gender" class="block text-sm font-semibold text-gray-700">
                                    Gender *
                                </label>
                                <select
                                    v-model="form.gender"
                                    id="gender"
                                    :class="[
                                        'w-full px-4 py-3 border rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.gender ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                                    <option value="">Select your gender</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                                <div v-if="form.errors.gender" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ form.errors.gender }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Date of Birth -->
                        <div class="mt-4">
                            <div class="space-y-2">
                                <label for="dob" class="block text-sm font-semibold text-gray-700">
                                    Date of Birth *
                                </label>
                                <input
                                    v-model="form.dob"
                                    type="date"
                                    id="dob"
                                    max="2007-12-31"
                                    :class="[
                                        'w-full px-4 py-3 border rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.dob ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                                <div v-if="form.errors.dob" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ form.errors.dob }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">You must be at least 16 years old to register</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>

                        <!-- Email -->
                        <div class="space-y-2 mb-4">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                Email Address *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    id="email"
                                    placeholder="Enter your email address"
                                    :class="[
                                        'w-full pl-10 pr-4 py-3 border rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.email ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                            </div>
                            <div v-if="form.errors.email" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ form.errors.email }}</span>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2 mb-4">
                            <label for="phone" class="block text-sm font-semibold text-gray-700">
                                Phone Number *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <input
                                    v-model="form.phone"
                                    type="tel"
                                    id="phone"
                                    placeholder="07XXXXXXXX (10 digits starting with 07)"
                                    :class="[
                                        'w-full pl-10 pr-4 py-3 border rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.phone ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    maxlength="10"
                                    pattern="07[0-9]{8}"
                                    required
                                >
                            </div>
                            <div v-if="form.errors.phone" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ form.errors.phone }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Enter your Zimbabwe mobile number (e.g., 0771234567)</p>
                        </div>

                        <!-- Address -->
                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700">
                                Address *
                            </label>
                            <textarea
                                v-model="form.address"
                                id="address"
                                rows="3"
                                placeholder="Enter your full address"
                                :class="[
                                    'w-full px-4 py-3 border rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none',
                                    form.errors.address ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                ]"
                                required
                            ></textarea>
                            <div v-if="form.errors.address" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ form.errors.address }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Security Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Security</h3>

                        <!-- Password -->
                        <div class="space-y-2 mb-4">
                            <label for="password" class="block text-sm font-semibold text-gray-700">
                                Password *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input
                                    v-model="form.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    id="password"
                                    placeholder="Create a strong password"
                                    :class="[
                                        'w-full pl-10 pr-12 py-3 border rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.password ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                >
                                    <svg v-if="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <div v-if="form.errors.password" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ form.errors.password }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters long</p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                                Confirm Password *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input
                                    v-model="form.password_confirmation"
                                    type="password"
                                    id="password_confirmation"
                                    placeholder="Confirm your password"
                                    :class="[
                                        'w-full pl-10 pr-4 py-3 border rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200',
                                        form.errors.password_confirmation ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                                    ]"
                                    required
                                >
                            </div>
                            <div v-if="form.errors.password_confirmation" class="flex items-center space-x-2 text-red-600 text-sm mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ form.errors.password_confirmation }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                v-model="form.terms"
                                id="terms"
                                type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors duration-200"
                                required
                            >
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-700">
                                I agree to the
                                <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors duration-200">Terms of Service</a>
                                and
                                <a href="#" class="text-blue-600 hover:text-blue-500 transition-colors duration-200">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        :disabled="loading || !form.terms"
                        type="submit"
                        :class="[
                            'group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white transition-all duration-200 transform',
                            loading || !form.terms
                                ? 'bg-gray-400 cursor-not-allowed'
                                : 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:shadow-lg hover:-translate-y-0.5'
                        ]"
                    >
                        <span v-if="loading" class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span v-if="!loading">Create Account</span>
                        <span v-if="loading">Creating Account...</span>
                    </button>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="/login" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors duration-200">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center text-xs text-gray-500 mt-8">
                <p>&copy; 2024 Universities Admission System. All rights reserved.</p>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default {
    setup() {
        const form = useForm({
            firstnames: '',
            surname: '',
            title: '',
            gender: '',
            phone: '',
            address: '',
            dob: '',
            email: '',
            password: '',
            password_confirmation: '',
            terms: false,
        });

        const loading = ref(false);
        const showPassword = ref(false);

        const submit = () => {
            loading.value = true;
            form.post('/register', {
                onFinish: () => {
                    loading.value = false;
                },
            });
        };

        return {
            form,
            loading,
            showPassword,
            submit,
        };
    },
};
</script>

<style scoped>
/* Custom animations and effects */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.bg-grid-pattern {
    background-image:
        linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
    background-size: 30px 30px;
}

.hover\:shadow-3xl:hover {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Focus states for better accessibility */
input:focus,
button:focus,
select:focus,
textarea:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
}

/* Custom scrollbar for webkit browsers */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Responsive design enhancements */
@media (max-width: 640px) {
    .min-h-screen {
        padding: 1rem;
    }

    .bg-white\/95 {
        padding: 1.5rem;
    }

    .grid-cols-1 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}

/* Light mode optimizations */
@media (prefers-color-scheme: light) {
    .bg-gradient-to-br {
        background: linear-gradient(to bottom right, #eff6ff, #ffffff, #f0f9ff);
    }
}

/* Form field enhancements */
textarea {
    resize: vertical;
    min-height: 80px;
}

select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Phone number formatting */
input[type="tel"] {
    font-family: monospace;
}
</style>
