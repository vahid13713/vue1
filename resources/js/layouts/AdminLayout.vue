<script setup lang="ts">
// ایمپورت‌های ضروری دیگر باقی می‌مانند
import type { BreadcrumbItemType } from '@/types';

// ایمپورت کامپوننت Layout
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';

// ۱. کامپوننت جدید پیام را ایمپورت کنید
import FlashMessage from '../components/FlashMessage.vue';

// Props کامپوننت
interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// ۲. منطق مربوط به گرفتن پیام از اینجا حذف می‌شود
// const page = usePage<AppPageProps>();
// const flash = computed(() => page.props.flash);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <!-- ۳. از کامپوننت جدید به جای کد قبلی استفاده کنید -->
        <FlashMessage />

        <!-- محتوای اصلی صفحه -->
        <slot />

    </AppLayout>
</template>```

