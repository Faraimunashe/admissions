<template>
    <Head title="Users" />

    <!-- Success Message -->
    <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ $page.props.flash.success }}</p>
            </div>
        </div>
    </div>

    <!-- Error Message -->
    <div v-if="$page.props.flash && $page.props.flash.error" class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ $page.props.flash.error }}</p>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Users Management</h3>
                    <p class="mt-1 text-sm text-gray-600">Manage system users and their roles</p>
                </div>
                <Link
                    href="/admin/users/create"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New User
                </Link>
            </div>
        </div>

        <div class="divide-y divide-gray-100">
            <div v-for="user in users.data" :key="user.id" class="px-6 py-5 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                                <span class="text-lg font-semibold text-white">
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <h4 class="text-lg font-semibold text-gray-900 truncate">{{ user.name }}</h4>
                                <span v-if="user.id === $page.props.auth.user.id"
                                      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    You
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ user.email }}</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <span v-for="role in user.roles" :key="role.id"
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ role.display_name || role.name }}
                                </span>
                                <span v-if="user.applicant"
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Applicant
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <!-- View Button -->
                        <Link
                            :href="`/admin/users/${user.id}`"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View
                        </Link>

                        <!-- Edit Button -->
                        <Link
                            :href="`/admin/users/${user.id}/edit`"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </Link>

                        <!-- Delete Button -->
                        <button
                            v-if="user.id !== $page.props.auth.user.id"
                            @click="confirmDelete(user)"
                            class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Applicant Details (if exists) -->
                <div v-if="user.applicant" class="mt-4 pl-16">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="font-medium">{{ user.applicant.title }} {{ user.applicant.firstnames }} {{ user.applicant.surname }}</span>
                            <span class="text-gray-400">•</span>
                            <span>{{ user.applicant.gender }}</span>
                            <span class="text-gray-400">•</span>
                            <span>{{ user.applicant.phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="users.data.length === 0" class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No users found</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by creating your first user account. You can assign roles and manage permissions.</p>
            <Link
                href="/admin/users/create"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-medium text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create First User
            </Link>
        </div>
    </div>

    <!-- Pagination -->
    <div v-if="users.data.length > 0" class="mt-8">
        <Pagination :links="users.links" />
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Delete User</h3>
                <p class="text-sm text-gray-600 text-center mb-6">
                    Are you sure you want to delete <strong>{{ userToDelete?.name }}</strong>? This action cannot be undone and will also delete their applicant profile if it exists.
                </p>
                <div class="flex space-x-3">
                    <button
                        @click="showDeleteModal = false"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteUser"
                        :disabled="deleting"
                        class="flex-1 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 transition-colors duration-200"
                    >
                        <span v-if="deleting" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Deleting...
                        </span>
                        <span v-else>Delete User</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Layout from '../../../Shared/Layout.vue';
import Pagination from '../../../Shared/Pagination.vue';

export default {
    layout: Layout,
    components: {
        Link,
        Pagination,
    },
    props: {
        users: Object,
    },
    setup() {
        const showDeleteModal = ref(false);
        const userToDelete = ref(null);
        const deleting = ref(false);

        const confirmDelete = (user) => {
            userToDelete.value = user;
            showDeleteModal.value = true;
        };

        const deleteUser = () => {
            if (userToDelete.value) {
                deleting.value = true;
                router.delete(`/admin/users/${userToDelete.value.id}`, {
                    onFinish: () => {
                        deleting.value = false;
                        showDeleteModal.value = false;
                        userToDelete.value = null;
                    },
                });
            }
        };

        return {
            showDeleteModal,
            userToDelete,
            deleting,
            confirmDelete,
            deleteUser,
        };
    },
};
</script>
