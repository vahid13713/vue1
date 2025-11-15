<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { AppPageProps } from '@/types';

const show = ref(false);
let timeout: number | null = null;

const page = usePage<AppPageProps>();
const flash = computed(() => page.props.flash);

watch(
    () => flash.value,
    (newFlash) => {
        if (newFlash && (newFlash.success || newFlash.error)) {
            if (timeout) {
                clearTimeout(timeout);
            }
            show.value = true;
            timeout = window.setTimeout(() => {
                show.value = false;
            }, 5000);
        }
    },
    {
        deep: true,
        immediate: true // <-- این خط مشکل را حل می‌کند
    }
);
</script>

<template>
    <!-- این بخش بدون تغییر باقی می‌ماند -->
    <transition
        enter-active-class="duration-300 ease-out"
        enter-from-class="transform opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="duration-200 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="transform opacity-0 translate-y-2"
    >
        <div
            v-if="show && (flash?.success || flash?.error)"
            class="fixed top-4 right-4 z-50 w-full max-w-sm rounded-lg shadow-lg"
        >
            <!-- بخش پیام موفقیت -->
            <div
                v-if="flash.success"
                class="flex items-center justify-between rounded-lg border-l-4 border-green-600 bg-white p-4 text-gray-700"
            >
                <div>{{ flash.success }}</div>
                <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-800">
                    <!-- SVG Icon -->
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- بخش پیام خطا -->
            <div
                v-if="flash.error"
                class="flex items-center justify-between rounded-lg border-l-4 border-red-600 bg-white p-4 text-gray-700"
            >
                <div>{{ flash.error }}</div>
                <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-800">
                    <!-- SVG Icon -->
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </transition>
</template>
