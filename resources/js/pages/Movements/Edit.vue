<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Movement, Category, BreadcrumbItem } from '@/types';

const props = defineProps<{
    movement: Movement;
    categories: Category[];
}>();

const form = useForm({
    type: props.movement.type,
    category_id: props.movement.category_id,
    quantity: props.movement.quantity,
    value: props.movement.value,
    date: props.movement.date,
    description: props.movement.description || '',
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Mouvements', href: route('movements.index') },
    { title: 'Modifier un mouvement' },
];
</script>

<template>

    <Head title="Modifier un mouvement" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Modifier un mouvement</h1>
            <form @submit.prevent="form.put(route('movements.update', movement.id))"
                class="space-y-4 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select v-model="form.type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="entry">Entrée</option>
                        <option value="exit">Sortie</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select v-model="form.category_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name
                            }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input v-model="form.quantity" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Valeur</label>
                    <input v-model="form.value" type="number" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input v-model="form.date" type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200 text-sm">Enregistrer</button>
            </form>
        </div>
    </AppLayout>
</template>