<template>
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand Section -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Admissions</h3>
                            <p class="text-sm text-gray-500">University System</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm max-w-md">
                        A comprehensive university admissions management system designed to streamline the application process for students and institutions.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="/admin/dashboard" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="/admin/institutes" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Institutes
                            </a>
                        </li>
                        <li>
                            <a href="/admin/programmes" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Programmes
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Support</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="/admin/help" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Help Center
                            </a>
                        </li>
                        <li>
                            <a href="/admin/contact" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Contact Us
                            </a>
                        </li>
                        <li>
                            <a href="/admin/documentation" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                Documentation
                            </a>
                        </li>
                        <li>
                            <a href="/admin/status" class="text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                System Status
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-6">
                        <p class="text-sm text-gray-500">
                            &copy; 2025 University Admissions System. All rights reserved.
                        </p>
                        <div class="hidden md:flex items-center space-x-4">
                            <a href="/privacy" class="text-sm text-gray-500 hover:text-blue-600 transition-colors duration-200">
                                Privacy Policy
                            </a>
                            <a href="/terms" class="text-sm text-gray-500 hover:text-blue-600 transition-colors duration-200">
                                Terms of Service
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 md:mt-0 flex items-center space-x-4">
                        <span class="text-sm text-gray-500">Built with</span>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-500">Laravel</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-500">Vue.js</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-500">Inertia.js</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
