<template>
    <Head title="User Details" />

    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">User Details</h1>
                <p class="mt-2 text-gray-600">View user information and profile</p>
            </div>
            <div class="flex space-x-3">
                <Link
                    :href="`/admin/users/${user.id}/edit`"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit User
                </Link>
                <Link
                    href="/admin/users"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Back to Users
                </Link>
            </div>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <!-- User Header -->
        <div class="px-4 py-5 sm:px-6 bg-gray-50">
            <div class="flex items-center">
                <img class="h-16 w-16 rounded-full border-2 border-gray-300"
                     src="../../../../assets/images/user.png"
                     :alt="user.name">
                <div class="ml-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ user.name }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ user.email }}</p>
                    <div class="mt-2">
                        <span v-for="role in user.roles" :key="role.id"
                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                            {{ role.display_name || role.name }}
                        </span>
                        <span v-if="user.applicant"
                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Has Applicant Profile
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">User ID</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ user.id }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ user.email }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ formatDate(user.created_at) }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ formatDate(user.updated_at) }}</dd>
                </div>
            </dl>
        </div>

        <!-- Applicant Profile Section -->
        <div v-if="user.applicant" class="border-t border-gray-200">
            <div class="px-4 py-5 sm:px-6 bg-green-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Applicant Profile</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal information and contact details</p>
            </div>

            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ user.applicant.title }} {{ user.applicant.firstnames }} {{ user.applicant.surname }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ user.applicant.gender }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ user.applicant.phone }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ formatDate(user.applicant.dob) }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ user.applicant.address }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Profile Created</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ formatDate(user.applicant.created_at) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Institute Associations -->
        <div v-if="user.institutes && user.institutes.length > 0" class="border-t border-gray-200">
            <div class="px-4 py-5 sm:px-6 bg-blue-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Institute Associations</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Institutes this user is associated with</p>
            </div>

            <div class="border-t border-gray-200">
                <ul class="divide-y divide-gray-200">
                    <li v-for="institute in user.institutes" :key="institute.id" class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ institute.name }}</p>
                                <p class="text-sm text-gray-500">{{ institute.phone }}</p>
                                <p class="text-sm text-gray-500">{{ institute.address }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Associated
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- No Applicant Profile Message -->
        <div v-if="!user.applicant" class="border-t border-gray-200">
            <div class="px-4 py-5 sm:px-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Applicant Profile</h3>
                <p class="mt-1 text-sm text-gray-500">This user does not have an applicant profile.</p>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Layout from '../../../Shared/Layout.vue';

export default {
    layout: Layout,
    components: {
        Link,
    },
    props: {
        user: Object,
    },
    setup() {
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            });
        };

        return {
            formatDate,
        };
    },
};
</script>
