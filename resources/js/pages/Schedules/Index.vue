<template>
    <AppLayout>
        <div class="container mx-auto p-4">
            <h2 class="text-2xl text-theme-black mb-4">Planning des tâches</h2>
            <p v-if="$page.props.flash.success" class="text-green-600 mb-4">{{ $page.props.flash.success }}</p>
            <div class="mb-4">
                <label for="dateFilter" class="block text-theme-black">Filtrer par date :</label>
                <input v-model="form.dateFilter" type="date" id="dateFilter"
                    class="border border-theme-black rounded w-full p-2 text-theme-black" @change="filterTasks" />
            </div>
            <div class="grid gap-4">
                <div v-for="task in tasks" :key="task.id"
                    class="bg-theme-white border border-theme-black rounded p-4 shadow-md">
                    <h3 class="text-lg font-bold text-theme-black">{{ task.title }}</h3>
                    <p class="text-theme-black">{{ task.description }}</p>
                    <p class="text-theme-black">Date : {{ task.date }}</p>
                    <p class="text-theme-black">Statut : {{ task.status ? 'Complétée' : 'En cours' }}</p>
                </div>
            </div>
            <inertia-link :href="route('tasks.create')" class="btn-primary mt-4 inline-block">
                Ajouter une tâche
            </inertia-link>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { InertiaLink } from '@inertiajs/vue3';

defineProps({
    tasks: Array,
    selectedDate: String,
});

const form = useForm({
    dateFilter: selectedDate,
});

function filterTasks() {
    form.get(route('tasks.index'), {
        preserveState: true,
        preserveScroll: true,
    });
}
</script>