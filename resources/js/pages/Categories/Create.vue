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
        <div class="p-4 sm:p-6 lg:p-8 bg-theme-white max-w-7xl mx-auto animate-fade-in-up">
            <h1
                class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-theme-black mb-6 relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-1.5 after:bg-gradient-to-r after:from-theme-blue after:to-theme-blue-dark after:transition-all after:duration-500 hover:after:w-1/3">
                Ajouter une catégorie
            </h1>
            <form @submit.prevent="form.post(route('categories.store'))" class="space-y-6">
                <div class="relative">
                    <label for="name"
                        class="absolute -top-3 left-3 bg-theme-white px-1 text-sm sm:text-base font-bold text-theme-black transition-all">Nom</label>
                    <input v-model="form.name" id="name" type="text"
                        class="block w-full rounded-lg border-2 border-theme-black/20 shadow-md focus:border-theme-blue focus:ring-2 focus:ring-theme-blue text-base sm:text-lg p-3 transition-all duration-300" />
                </div>
                <div class="relative">
                    <label for="description"
                        class="absolute -top-3 left-3 bg-theme-white px-1 text-sm sm:text-base font-bold text-theme-black transition-all">Description</label>
                    <textarea v-model="form.description" id="description"
                        class="block w-full rounded-lg border-2 border-theme-black/20 shadow-md focus:border-theme-blue focus:ring-2 focus:ring-theme-blue text-base sm:text-lg p-3 min-h-24 transition-all duration-300"></textarea>
                </div>
                <div class="relative">
                    <label for="unit"
                        class="absolute -top-3 left-3 bg-theme-white px-1 text-sm sm:text-base font-bold text-theme-black transition-all">Unité</label>
                    <input v-model="form.unit" id="unit" type="text"
                        class="block w-full rounded-lg border-2 border-theme-black/20 shadow-md focus:border-theme-blue focus:ring-2 focus:ring-theme-blue text-base sm:text-lg p-3 transition-all duration-300" />
                </div>
                <button type="submit" class="btn-gradient text-sm sm:text-base lg:text-lg font-bold">
                    <i class="fa-solid fa-save fa-sm sm:fa-md lg:fa-lg mr-2"></i> Enregistrer
                </button>
            </form>
        </div>
    </AppLayout>
</template>