<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { LayoutGrid } from 'lucide-vue-next';

// منوی مخصوص ادمین
const adminNavItems: NavItem[] = [
    {
        title: 'Agent Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Agent Users',
        href: '/agent/users', // برای ثبات، بهتر است از تابع route() استفاده شود
        icon: LayoutGrid,
    },
    {
        title: 'Agent Create Users',
        href: '/agent/users/create', // برای ثبات، بهتر است از تابع route() استفاده شود
        icon: LayoutGrid,
    },
    // ... سایر لینک‌های ادمین
];
</script>

<template>
    <NavMain :items="adminNavItems" />
</template>
