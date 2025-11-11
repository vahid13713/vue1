<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

// Define breadcrumbs for navigation
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Users', href: '/users' },
    { title: 'Create', href: '/users/create' },
];

// Get the current user's role to conditionally show role options
const authUser = computed(() => usePage().props.auth.user);

// Initialize the form with Inertia's useForm hook
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: authUser.value?.role === 'agent' ? 'user' : '', // Pre-select role for agents
});

// Function to handle form submission
function submit() {
    form.post('/users', {
        onFinish: () => {
            // Optional: You can clear the password fields on finish
            form.reset('password', 'password_confirmation');
        },
    });
}
</script>

<template>
    <Head title="Create User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-y-auto rounded-xl p-4">
            <div class="rounded-xl border border-sidebar-border/70 bg-white p-6 shadow-md transition-all duration-300 ease-in-out hover:shadow-lg dark:border-sidebar-border dark:bg-gray-800">

                <h3 class="mb-6 text-xl font-semibold text-gray-900 dark:text-white">
                    Create New User
                </h3>

                <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input v-model="form.name" type="text" id="name" class="block w-full rounded-lg border ..." placeholder="John Doe" />
                        <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input v-model="form.email" type="email" id="email" class="block w-full rounded-lg border ..." placeholder="name@example.com" />
                        <div v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input v-model="form.password" type="password" id="password" class="block w-full rounded-lg border ..." />
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</div>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                        <input v-model="form.password_confirmation" type="password" id="password_confirmation" class="block w-full rounded-lg border ..." />
                    </div>

                    <!-- Role Select -->
                    <div v-if="authUser?.role === 'admin'">
                        <label for="role" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select v-model="form.role" id="role" class="block w-full rounded-lg border ...">
                            <option value="" disabled>Select a role</option>
                            <option value="agent">Agent</option>
                            <option value="user">User</option>
                        </select>
                        <div v-if="form.errors.role" class="mt-1 text-sm text-red-600">{{ form.errors.role }}</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-span-1 flex items-end md:col-span-2">
                        <button type="submit" :disabled="form.processing" class="rounded-lg bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50">
                            Create User
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </AppLayout>
</template>
