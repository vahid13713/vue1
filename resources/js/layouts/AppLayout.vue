<script setup lang="ts">
// ۱. ایمپورت‌های ضروری برای گرفتن پیام
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { BreadcrumbItemType, AppPageProps } from '@/types'; // این تایپ برای جلوگیری از خطا لازم است

// ایمپورت کامپوننت Layout (که داخل خودش استفاده می‌شود)
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';

// Props کامپوننت (کد اصلی خودتان)
interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// ۲. گرفتن پیام فلش به ساده‌ترین شکل
const page = usePage<AppPageProps>();
const flash = computed(() => page.props.flash);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <!-- ۳. نمایش پیام در یک نوار ساده سبز رنگ -->
        <div v-if="flash?.success" class="mb-4 rounded-md bg-green-500 p-4 text-white">
            {{ flash.success }}
        </div>

        <!-- محتوای اصلی صفحه -->
        <slot />

    </AppLayout>
</template>
