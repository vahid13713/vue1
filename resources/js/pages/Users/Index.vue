<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

// 1. پراپ‌ها برای دریافت داده‌های کاربران از کنترلر تعریف شده‌اند.
const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
});

// 2. مسیرهای راهنما (Breadcrumbs) برای این صفحه تعریف شده‌اند.
// فرض بر این است که شما پروپرتی `href` را در تعریف `BreadcrumbItem` اختیاری کرده‌اید (`href?: string`).
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'داشبورد',
        href: '/dashboard',
    },
    {
        title: 'کاربران من',
        href: '#',
    },
];
</script>

<template>
    <Head title="کاربران من" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="rounded-xl border border-sidebar-border/70 bg-white p-4 dark:border-sidebar-border dark:bg-gray-800">

                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                    لیست کاربران زیرمجموعه
                </h3>

                <!-- جدول نمایش کاربران -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">نام</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">ایمیل</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">نقش</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">تاریخ عضویت</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        <!-- پیام در صورت خالی بودن لیست -->
                        <tr v-if="props.users.data.length === 0">
                            <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="4">
                                هیچ کاربری برای نمایش وجود ندارد.
                            </td>
                        </tr>
                        <!-- حلقه برای نمایش هر کاربر -->
                        <tr v-for="user in props.users.data" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ user.name }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ user.email }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ user.role }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ new Date(user.created_at).toLocaleDateString('fa-IR') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- 3. بخش صفحه‌بندی (Pagination) - اصلاح شده -->
                <div v-if="props.users.links.length > 3" class="mt-4 flex flex-col items-center justify-between space-y-2 sm:flex-row sm:space-y-0">
                    <div class="text-sm text-gray-700 dark:text-gray-400">
                        نمایش از {{ props.users.from }} تا {{ props.users.to }} از مجموع {{ props.users.total }} نتیجه
                    </div>
                    <div class="flex flex-wrap justify-center">
                        <template v-for="(link, key) in props.users.links" :key="key">
                            <!-- لینک‌های غیرفعال (مانند ...) -->
                            <div
                                v-if="link.url === null"
                                class="mr-1 mb-1 rounded border border-gray-300 px-3 py-2 text-sm leading-4 text-gray-400 dark:border-gray-600"
                            >
                                <span v-html="link.label"></span>
                            </div>
                            <!-- لینک‌های فعال -->
                            <Link
                                v-else
                                class="mr-1 mb-1 rounded border border-gray-300 px-3 py-2 text-sm leading-4 hover:bg-gray-100 focus:border-indigo-500 focus:text-indigo-500 dark:border-gray-600 dark:hover:bg-gray-700"
                                :class="{ 'bg-blue-600 text-white dark:bg-blue-800 border-blue-600 dark:border-blue-800': link.active }"
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
