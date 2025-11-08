<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'

const breadcrumbs = [
    { title: 'Hello', href: '/hello' },
]
</script>

<template>
    <Head title="Hello" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="text-2xl font-semibold mb-2">Hello</h1>
            <p class="text-lg">Hello World</p>
        </div>
    </AppLayout>
</template>
