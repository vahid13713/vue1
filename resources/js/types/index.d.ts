import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

// ==========================================================
// شروع تغییرات
// ==========================================================

// ۱. این بخش برای تعریف ساختار پیام فلش اضافه شده است
export interface FlashMessages {
    success?: string;
    error?: string;
}

// ==========================================================
// پایان تغییرات
// ==========================================================

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;

    // ==========================================================
    // شروع تغییرات
    // ==========================================================

    // ۲. پراپرتی flash به پراپ‌های اصلی صفحه اضافه شده است
    flash: FlashMessages;

    // ==========================================================
    // پایان تغییرات
    // ==========================================================
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    role?: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
