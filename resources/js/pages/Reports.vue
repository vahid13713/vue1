<script setup>
import AppLayout from '@/layouts/AppLayout.vue'; // لایه اصلی برنامه شما
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="گزارش‌ها" />

    <AppLayout>
        <!-- این بخش، هدر بالای صفحه را پر می‌کند -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                گزارش‌ها
            </h2>
        </template>

        <!-- این بخش، محتوای اصلی صفحه است -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        اینجا محتوای صفحه گزارش‌ها قرار می‌گیرد.
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
