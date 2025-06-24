<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Category, BreadcrumbItem } from '@/types';

const props = defineProps<{
    categories: Category[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Catégories', href: route('categories.index') },
];
</script>

<template>

    <Head title="Catégories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 sm:p-6 lg:p-8 bg-theme-white rounded animate-fade-in-up">
            <h1
                class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-theme-black mb-6 relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-1.5 after:bg-gradient-to-r after:from-theme-blue after:to-theme-blue-dark after:transition-all after:duration-500 hover:after:w-1/3">
                Catégories
            </h1>
            <Link :href="route('categories.create')"
                class="btn-gradient mb-6 inline-block text-sm bg-theme-blue text-white rounded p-2 sm:text-base lg:text-lg font-bold">
            <i class="fa-solid fa-plus fa-sm sm:fa-md lg:fa-lg mr-2"></i> Ajouter une catégorie
            </Link>
            <div class="overflow-x-auto">
                <table class="min-w-full border-2 border-theme-black/60 rounded-lg shadow-lg">
                    <thead class="bg-theme-blue/100 text-white">
                        <tr>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-base sm:text-lg font-bold text-theme-white uppercase tracking-wider">
                                Nom
                            </th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-base sm:text-lg font-bold text-theme-white uppercase tracking-wider">
                                Unité
                            </th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-base sm:text-lg font-bold text-theme-white uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-theme-black/30">
                        <tr v-for="(category, index) in categories" :key="category.id" class="table-row"
                            :class="{ 'bg-theme-blue/5': index % 2 }">
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap text-base sm:text-lg lg:text-xl font-bold text-theme-black">
                                {{ category.name }}</td>
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap text-base sm:text-lg lg:text-xl font-bold text-theme-black">
                                {{ category.unit }}</td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap flex gap-3">
                                <Link :href="route('categories.edit', category.id)"
                                    class="action-btn bg-theme-blue/10 hover:bg-theme-blue text-theme-blue hover:text-theme-white">
                                <i class="fa-solid fa-edit fa-sm sm:fa-md lg:fa-lg mr-1"></i> Modifier
                                </Link>
                                <form @submit.prevent="$inertia.delete(route('categories.destroy', category.id))"
                                    class="inline">
                                    <button type="submit"
                                        class="action-btn bg-theme-red/80 hover:bg-theme-red/40 text-[--theme-red] hover:text-theme-black/80">
                                        <i class="fa-solid fa-trash fa-sm sm:fa-md lg:fa-lg mr-1"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>