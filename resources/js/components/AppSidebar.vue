<script setup lang="ts">
// بخش‌های ثابت و مشترک سایدبار
import NavFooter from '@/components/NavFooter.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import AppLogo from './AppLogo.vue';

// ابزارهای Vue و Inertia برای منطق داینامیک
import { computed, defineAsyncComponent } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

// آیکون‌ها و روت‌ها
import { BookOpen, Folder } from 'lucide-vue-next';
import { dashboard } from '@/routes'; // فقط روت داشبورد اصلی را نیاز داریم

// 1. اطلاعات کاربر و نقش او را از اینرشا دریافت می‌کنیم
const user = computed(() => usePage().props.auth.user);
const userRole = computed(() => user.value?.role);

// 2. کامپوننت منو را بر اساس نقش کاربر به صورت داینامیک انتخاب می‌کنیم
const NavMenuComponent = computed(() => {
    switch (userRole.value) {
        case 'admin':
            return defineAsyncComponent(() => import('@/components/menus/AdminNav.vue'));
        case 'agent':
            return defineAsyncComponent(() => import('@/components/menus/AgentNav.vue'));
        case 'user':
            return defineAsyncComponent(() => import('@/components/menus/UserNav.vue'));
        default:
            // برای کاربران مهمان یا نقش‌های نامشخص، منویی نمایش داده نمی‌شود
            return null;
    }
});

// 3. آیتم‌های فوتر که برای همه یکسان است
const footerNavItems = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <!-- هدر سایدبار (بخش مشترک) -->
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <!-- ✅ لینک لوگو اکنون ساده و ثابت است و همیشه به داشبورد اصلی می‌رود -->
                        <Link :href="dashboard().url">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <!-- محتوای اصلی سایدبار (بخش داینامیک) -->
        <SidebarContent>
            <component :is="NavMenuComponent" />
        </SidebarContent>

        <!-- فوتر سایدبار (بخش مشترک) -->
        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
