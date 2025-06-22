<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { BreadcrumbItem } from '@/types';

const form = useForm({
    name: '',
    description: '',
    unit: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Catégories', href: route('categories.index') },
    { title: 'Ajouter une catégorie' },
];
</script>

<template>

    <Head title="Ajouter une catégorie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Ajouter une catégorie</h1>
            <form @submit.prevent="form.post(route('categories.store'))" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom</label>
                    <input v-model="form.name" type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Unité</label>
                    <input v-model="form.unit" type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-800">Enregistrer</button>
            </form>
        </div>
    </AppLayout>
</template>