<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import { dashboard } from '@/routes/user';
import { type NavItem } from '@/types';
import { LayoutGrid } from 'lucide-vue-next';

// منوی مخصوص کاربر عادی
const userNavItems: NavItem[] = [
    {
        title: 'User Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    // ... سایر لینک‌های کاربر
];
</script>

<template>
    <NavMain :items="userNavItems" />
</template>
