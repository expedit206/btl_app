<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import CategoryCard from '../../components/PlaceholderPattern.vue'; // Remplace si tu as CategoryCard.vue

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Categories', href: '/categories' },
];

defineProps<{
    categories: any[];
}>();
</script>

<template>

    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-6">

            <!-- Titre de la page -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Browse Categories</h1>
                <Link :href="route('categories.create')"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 transition duration-200">
                + Add Category
                </Link>
            </div>

            <!-- Liste des catégories -->
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                <CategoryCard v-for="category in categories" :key="category.id" :category="category" />
            </div>

            <!-- Si aucune catégorie -->
            <div v-if="categories.length === 0"
                class="mt-10 rounded-lg border-2 border-dashed border-gray-300 p-8 text-center text-gray-500 dark:border-gray-600 dark:text-gray-400">
                No categories available. Add a new one to get started.
            </div>
        </div>
    </AppLayout>
</template>
