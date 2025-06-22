<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Category, BreadcrumbItem } from '@/types';

const props = defineProps < {
    categories: Category[];
} > ();

const form = useForm({
    type: 'entry',
    category_id: '',
    quantity: '',
    value: '',
    date: '',
    description: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Mouvements', href: route('movements.index') },
    { title: 'Ajouter un mouvement' },
];
</script>

<template>

    <Head title="Ajouter un mouvement" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Ajouter un mouvement</h1>
            <form @submit.prevent="form.post(route('movements.store'))" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select v-model="form.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="entry">Entrée</option>
                        <option value="exit">Sortie</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select v-model="form.category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name
                            }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input v-model="form.quantity" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Valeur</label>
                    <input v-model="form.value" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input v-model="form.date" type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-800">Enregistrer</button>
            </form>
        </div>
    </AppLayout>
</template>