<template>
    <div class="relative" v-cloak>
        <!-- User Profile Button -->
        <button
            @click.stop="toggleDropdown"
            class="flex items-center space-x-3 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 p-1 hover:bg-gray-50 transition-colors duration-200"
        >
            <span class="sr-only">Open user menu</span>
            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                <span class="text-xs font-medium text-white">
                    {{ username.charAt(0).toUpperCase() }}
                </span>
            </div>
            <div class="hidden md:block text-left">
                <p class="text-sm font-medium text-gray-900">{{ username }}</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-if="isOpen"
                class="origin-top-right absolute right-0 mt-2 w-64 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu"
            >
                <!-- User Info Header -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-white">
                                {{ username.charAt(0).toUpperCase() }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ username }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="py-2">
                    <a href="/admin/profile"
                        class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                        role="menuitem"
                    >
                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Your Profile
                    </a>

                    <a href="/admin/settings"
                        class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                        role="menuitem"
                    >
                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>

                    <a href="/admin/notifications"
                        class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                        role="menuitem"
                    >
                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-6a4 4 0 00-8 0v6z"></path>
                        </svg>
                        Notifications
                    </a>
                </div>

                <!-- Sign Out -->
                <div class="py-2">
                    <Link href="/logout" method="post"
                        class="flex items-center px-6 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200"
                        role="menuitem"
                    >
                        <svg class="mr-3 h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sign out
                    </Link>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
    props: {
        username: String
    },
    setup() {
        const isOpen = ref(false);

        const toggleDropdown = () => {
            isOpen.value = !isOpen.value;
        };

        const handleOutsideClick = (event) => {
            // Close dropdown if clicking outside
            if (!event.target.closest('.relative')) {
                isOpen.value = false;
            }
        };

        onMounted(() => {
            window.addEventListener('click', handleOutsideClick);
        });

        onUnmounted(() => {
            window.removeEventListener('click', handleOutsideClick);
        });

        return {
            isOpen,
            toggleDropdown,
        };
    },
};
</script>
