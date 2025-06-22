<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { Movement, BreadcrumbItemType } from '@/types';

const props = defineProps<{
    movements: Movement[];
    filters: {
        date_from?: string;
        date_to?: string;
        type?: string;
    };
}>();

const form = useForm({
    date_from: props.filters.date_from || '',
    date_to: props.filters.date_to || '',
    type: props.filters.type || '',
});

const deleteForm = useForm({});

const breadcrumbs: BreadcrumbItemType[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Mouvements', href: route('movements.index') },
];

// Calcul des totaux
const totalEntries = computed(() => {
    return props.movements
        .filter((m) => m.type === 'entry')
        .reduce((sum, m) => sum + Number(m.value), 0);
});

const totalExits = computed(() => {
    return props.movements
        .filter((m) => m.type === 'exit')
        .reduce((sum, m) => sum + Number(m.value), 0);
});

const net = computed(() => totalEntries.value - totalExits.value);

// Fonction pour exporter en CSV
const exportToCSV = () => {
    const headers = ['ID', 'Type', 'Catégorie', 'Quantité', 'Valeur (€)', 'Date', 'Description'];
    const rows = props.movements.map((m) => [
        m.id,
        m.type === 'entry' ? 'Entrée' : 'Sortie',
        m.category.name,
        Number(m.quantity).toFixed(2),
        Number(m.value).toFixed(2),
        m.date,
        m.description || '',
    ]);

    const csvContent = [
        headers.join(','),
        ...rows.map((row) => row.map((cell) => `"${cell}"`).join(',')),
    ].join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.setAttribute('download', 'movements_export.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

const confirmDelete = (movementId: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ?')) {
        deleteForm.delete(route('movements.destroy', movementId));
    }
};
</script>

<template>

    <Head title="Mouvements" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Mouvements</h1>

            <!-- Formulaire de filtrage -->
            <form @submit.prevent="form.get(route('movements.index'), { preserveState: true })"
                class="mb-6 flex flex-col sm:flex-row gap-4 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Date de début</label>
                    <input v-model="form.date_from" type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                    <input v-model="form.date_to" type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select v-model="form.type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">Tous</option>
                        <option value="entry">Entrée</option>
                        <option value="exit">Sortie</option>
                    </select>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200 text-sm self-end">
                    Filtrer
                </button>
            </form>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <Link :href="route('movements.create')"
                    class="inline-block px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600 transition duration-200 text-sm">
                Ajouter un mouvement
                </Link>
                <button @click="exportToCSV"
                    class="inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200 text-sm">
                    Exporter en CSV
                </button>
            </div>

            <!-- Bilan financier -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Résumé financier</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                        <h3 class="text-base sm:text-lg font-medium text-gray-700">Total des entrées</h3>
                        <p class="text-xl sm:text-2xl text-indigo-600">{{ totalEntries.toFixed(2) }} €</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                        <h3 class="text-base sm:text-lg font-medium text-gray-700">Total des sorties</h3>
                        <p class="text-xl sm:text-2xl text-red-600">{{ totalExits.toFixed(2) }} €</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                        <h3 class="text-base sm:text-lg font-medium text-gray-700">Solde net</h3>
                        <p class="text-xl sm:text-2xl" :class="net >= 0 ? 'text-green-600' : 'text-red-600'">
                            {{ net.toFixed(2) }} €
                        </p>
                    </div>
                </div>
            </div>

            <!-- Liste des mouvements (tableau pour desktop) -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Catégorie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Valeur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="movement in movements" :key="movement.id"
                            class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span :class="movement.type === 'entry' ? 'text-green-600' : 'text-red-600'">
                                    {{ movement.type === 'entry' ? 'Entrée' : 'Sortie' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ movement.category.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ Number(movement.quantity).toFixed(2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ Number(movement.value).toFixed(2) }} €
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ movement.date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <Link :href="route('movements.edit', movement.id)"
                                    class="text-indigo-600 hover:text-indigo-900 mr-2">
                                Modifier
                                </Link>
                                <button @click="confirmDelete(movement.id)" class="text-red-600 hover:text-red-900">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Liste des mouvements (cartes pour mobile) -->
            <div class="block sm:hidden space-y-4">
                <div v-for="movement in movements" :key="movement.id"
                    class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium"
                            :class="movement.type === 'entry' ? 'text-green-600' : 'text-red-600'">
                            {{ movement.type === 'entry' ? 'Entrée' : 'Sortie' }}
                        </span>
                        <span class="text-xs text-gray-500">{{ movement.date }}</span>
                    </div>
                    <p class="text-sm text-gray-700">Catégorie: {{ movement.category.name }}</p>
                    <p class="text-sm text-gray-700">Quantité: {{ Number(movement.quantity).toFixed(2) }}</p>
                    <p class="text-sm text-gray-700">Valeur: {{ Number(movement.value).toFixed(2) }} €</p>
                    <div class="mt-2">
                        <Link :href="route('movements.edit', movement.id)"
                            class="text-indigo-600 hover:text-indigo-900 text-sm mr-2">
                        Modifier
                        </Link>
                        <button @click="confirmDelete(movement.id)" class="text-red-600 hover:text-red-900 text-sm">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>