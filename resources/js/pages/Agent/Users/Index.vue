<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from 'lodash.debounce';

// 1. Define props to receive data and filter state from the controller
const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'My Users',
        href: '/users',
    },
];

// 2. Create reactive variables for each filter, initialized from props
const search = ref(props.filters.search);
const role = ref(props.filters.role);
const createdFrom = ref(props.filters.created_from);
const createdTo = ref(props.filters.created_to);

// 3. Watch for changes in any filter and send a new request to the server
// Debounce is used to avoid sending too many requests while the user is typing
watch(
    [search, role, createdFrom, createdTo],
    debounce(function ([newSearch, newRole, newCreatedFrom, newCreatedTo]) {
        router.get(
            '/users',
            {
                search: newSearch,
                role: newRole,
                created_from: newCreatedFrom,
                created_to: newCreatedTo,
            },
            {
                preserveState: true, // Keep the user's scroll position and component state
                replace: true, // Avoid polluting browser history with filter changes
            },
        );
    }, 300), // Wait 300ms after the user stops typing
);
</script>

<template>
    <Head title="My Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="rounded-xl border border-sidebar-border/70 bg-white p-4 shadow-md transition-all duration-300 ease-in-out hover:shadow-lg dark:border-sidebar-border dark:bg-gray-800"
            >
                <h3
                    class="mb-4 text-lg font-semibold text-gray-900 dark:text-white"
                >
                    Users List
                </h3>
                <Link
                    :href="'/users/create'"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-blue-700 dark:hover:bg-blue-800"
                >
                    Add New User
                </Link>

                <!-- 4. Filter form section -->
                <div
                    class="mb-4 flex flex-col items-center gap-4 sm:flex-row sm:flex-wrap"
                >
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-auto sm:flex-grow">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search by name and email..."
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        />
                    </div>
                    <!-- Role Select -->
                    <select
                        v-model="role"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:w-48 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    >
                        <option :value="null">All Roles</option>
                        <option value="agent">Agent</option>
                        <option value="user">User</option>
                    </select>

                    <!-- Date From Input -->
                    <div class="relative w-full sm:w-48">
                        <input
                            v-model="createdFrom"
                            type="date"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        />
                    </div>
                    <!-- Date To Input -->
                    <div class="relative w-full sm:w-48">
                        <input
                            v-model="createdTo"
                            type="date"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        />
                    </div>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table
                        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
                    >
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-300"
                                >
                                    Name
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-300"
                                >
                                    Email
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-300"
                                >
                                    Role
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-300"
                                >
                                    Date Joined
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
                        >
                            <tr v-if="props.users.data.length === 0">
                                <td
                                    class="px-6 py-4 text-center text-sm text-gray-500"
                                    colspan="4"
                                >
                                    No users found with these criteria.
                                </td>
                            </tr>
                            <tr
                                v-for="user in props.users.data"
                                :key="user.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <td
                                    class="px-6 py-4 text-sm font-medium whitespace-nowrap text-gray-900 dark:text-white"
                                >
                                    {{ user.name }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-300"
                                >
                                    {{ user.email }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-300"
                                >
                                    {{ user.role }}
                                </td>
                                <td
                                    class="px-6 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-300"
                                >
                                    {{
                                        new Date(
                                            user.created_at,
                                        ).toLocaleDateString('en-CA')
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div
                    v-if="props.users.links.length > 3"
                    class="mt-4 flex flex-col items-center justify-between space-y-2 sm:flex-row sm:space-y-0"
                >
                    <div class="text-sm text-gray-700 dark:text-gray-400">
                        Showing {{ props.users.from }} to
                        {{ props.users.to }} of {{ props.users.total }} results
                    </div>
                    <div class="flex flex-wrap justify-center">
                        <template
                            v-for="(link, key) in props.users.links"
                            :key="key"
                        >
                            <div
                                v-if="link.url === null"
                                class="mr-1 mb-1 rounded border border-gray-300 px-3 py-2 text-sm leading-4 text-gray-400 dark:border-gray-600"
                            >
                                <span v-html="link.label"></span>
                            </div>
                            <Link
                                v-else
                                class="mr-1 mb-1 rounded border border-gray-300 px-3 py-2 text-sm leading-4 hover:bg-gray-100 focus:border-indigo-500 focus:text-indigo-500 dark:border-gray-600 dark:hover:bg-gray-700"
                                :class="{
                                    'border-blue-600 bg-blue-600 text-white dark:border-blue-800 dark:bg-blue-800':
                                        link.active,
                                }"
                                :href="link.url"
                            >
                                <span v-html="link.label"></span>
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
