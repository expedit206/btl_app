<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import CategoryCard from '../../components/PlaceholderPattern.vue'; // Remplace par CategoryCard si disponible

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

defineProps<{
    categories: any[];
}>();
</script>

<template>

    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <CategoryCard v-for="category in categories" :key="category.id" :category="category" />
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <inertia-link :href="route('categories.create')" class="btn-primary mt-4 inline-block">
                    Add Category
                </inertia-link>
            </div>
        </div>
    </AppLayout>
</template>