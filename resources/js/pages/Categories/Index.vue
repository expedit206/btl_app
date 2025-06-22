<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Category, BreadcrumbItem } from '@/types';

const props = defineProps < {
    categories: Category[];
} > ();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Catégories', href: route('categories.index') },
];
</script>

<template>

    <Head title="Catégories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Catégories</h1>
            <Link :href="route('categories.create')"
                class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-800">
            Ajouter une catégorie
            </Link>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Unité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="category in categories" :key="category.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ category.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ category.unit }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <Link :href="route('categories.edit', category.id)"
                                    class="text-indigo-600 hover:text-indigo-900">Modifier</Link>
                                <form @submit.prevent="$inertia.delete(route('categories.destroy', category.id))"
                                    class="inline ml-2">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>