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
    const headers = ['ID', 'Type', 'Catégorie', 'Quantité', 'Valeur (FCFA)', 'Date', 'Description'];
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
        <div class="p-4 sm:p-6 lg:p-8 bg-theme-white max-w-7xl mx-auto animate-fade-in-up min-h-screen">
            <h1
                class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-theme-black mb-6 relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-1.5 after:bg-gradient-to-r after:from-theme-blue after:to-theme-blue-dark after:transition-all after:duration-500 hover:after:w-1/3">
                Mouvements
            </h1>

            <!-- Formulaire de filtrage -->
            <form @submit.prevent="form.get(route('movements.index'), { preserveState: true })"
                class="mb-6 flex flex-col sm:flex-row gap-4 bg-theme-white p-4 sm:p-6 rounded-lg shadow-md">
                <div class="flex-1 relative">
                    <label for="date_from"
                        class="absolute -top-3 left-3 bg-theme-white px-1 text-sm sm:text-base font-bold text-theme-black transition-all">Date
                        de début</label>
                    <input v-model="form.date_from" id="date_from" type="date"
                        class="block w-full rounded-lg border-2 border-theme-black/20 shadow-md focus:border-theme-blue focus:ring-2 focus:ring-theme-blue text-sm sm:text-base lg:text-lg p-3 transition-all duration-300" />
                </div>
                <div class="flex-1 relative">
                    <label for="date_to"
                        class="absolute -top-3 left-3 bg-theme-white px-1 text-sm sm:text-base font-bold text-theme-black transition-all">Date
                        de fin</label>
                    <input v-model="form.date_to" id="date_to" type="date"
                        class="block w-full rounded-lg border-2 border-theme-black/20 shadow-md focus:border-theme-blue focus:ring-2 focus:ring-theme-blue text-sm sm:text-base lg:text-lg p-3 transition-all duration-300" />
                </div>
                <div class="flex-1 relative">
                    <label for="type"
                        class="absolute -top-3 left-3 bg-theme-white px-1 text-sm sm:text-base font-bold text-theme-black transition-all">Type</label>
                    <select v-model="form.type" id="type"
                        class="block w-full rounded-lg border-2 border-theme-black/20 shadow-md focus:border-theme-blue focus:ring-2 focus:ring-theme-blue text-sm sm:text-base lg:text-lg p-3 transition-all duration-300">
                        <option value="">Tous</option>
                        <option value="entry">Entrée</option>
                        <option value="exit">Sortie</option>
                    </select>
                </div>
                <button type="submit" class="btn-gradient text-sm sm:text-base font-bold self-end">
                    <i class="fa-solid fa-filter fa-sm sm:fa-md mr-2"></i> Filtrer
                </button>
            </form>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <Link :href="route('movements.create')" class="btn-gradient text-sm sm:text-base font-bold">
                <i class="fa-solid fa-plus fa-sm sm:fa-md mr-2"></i> Ajouter un mouvement
                </Link>
                <button @click="exportToCSV" class="btn-gradient text-sm sm:text-base font-bold">
                    <i class="fa-solid fa-file-export fa-sm sm:fa-md mr-2"></i> Exporter en CSV
                </button>
            </div>

            <!-- Bilan financier -->
            <div class="mb-6">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-theme-black mb-4">Résumé financier</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div
                        class="bg-gradient-to-r from-theme-blue to-theme-blue-dark p-4 rounded-lg shadow-lg hover:scale-105 transition-all duration-300">
                        <h3 class="text-base sm:text-lg lg:text-xl font-bold text-theme-white">Total des entrées</h3>
                        <p class="text-lg sm:text-xl lg:text-2xl text-theme-blue/100">{{ totalEntries.toFixed(2) }} FCFA
                        </p>
                    </div>
                    <div
                        class="bg-gradient-to-r from-theme-red to-red-700 p-4 rounded-lg shadow-lg shadow-black/50 hover:scale-105 transition-all duration-300">
                        <h3 class="text-base sm:text-lg lg:text-xl font-bold text-theme-black   ">Total des sorties</h3>
                        <p class="text-lg sm:text-xl lg:text-2xl text-theme-black">{{ totalExits.toFixed(2) }} FCFA</p>
                    </div>
                    <div
                        class="bg-gradient-to-r from-theme-black to-gray-800 p-4 rounded-lg shadow-lg hover:scale-105 transition-all duration-300">
                        <h3 class="text-base sm:text-lg lg:text-xl font-bold text-theme-white">Solde net</h3>
                        <p class="text-lg sm:text-xl lg:text-2xl" :class="net >= 0 ? 'text-green-400' : 'text-red-400'">
                            {{ net.toFixed(2) }} FCFA
                        </p>
                    </div>
                </div>
            </div>

            <!-- Liste des mouvements (tableau pour desktop) -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full border-2 border-theme-black/60 rounded-lg shadow-lg">
                    <thead class="bg-theme-blue/10">
                        <tr>
                            <th
                                class="px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-theme-black uppercase tracking-wider">
                                Type
                            </th>
                            <th
                                class="px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-theme-black uppercase tracking-wider">
                                Catégorie
                            </th>
                            <th
                                class="px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-theme-black uppercase tracking-wider">
                                Quantité
                            </th>
                            <th
                                class="px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-theme-black uppercase tracking-wider">
                                Valeur
                            </th>
                            <th
                                class="px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-theme-black uppercase tracking-wider">
                                Date
                            </th>
                            <th
                                class="px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-theme-black uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-theme-black/20">
                        <tr v-for="(movement, index) in movements" :key="movement.id" class="table-row"
                            :class="{ 'bg-theme-blue/5': index % 2 }">
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm sm:text-base lg:text-lg font-semibold text-theme-blue-dark">
                                <span :class="movement.type === 'entry' ? 'text-green-600' : 'text-[--theme-red]'">
                                    {{ movement.type === 'entry' ? 'Entrée' : 'Sortie' }}
                                </span>
                            </td>
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm sm:text-base lg:text-lg font-semibold text-theme-blue-dark">
                                {{ movement.category.name }}</td>
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm sm:text-base lg:text-lg font-semibold text-theme-blue-dark">
                                {{ Number(movement.quantity).toFixed(2) }}</td>
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm sm:text-base lg:text-lg font-semibold text-theme-blue-dark">
                                {{ Number(movement.value).toFixed(2) }} FCFA</td>
                            <td
                                class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm sm:text-base lg:text-lg font-semibold text-theme-blue-dark">
                                {{ movement.date }}</td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap flex items-center gap-3">
                                <Link :href="route('movements.edit', movement.id)"
                                    class="action-btn bg-theme-blue/10 hover:bg-theme-blue text-theme-blue hover:text-theme-white text-sm sm:text-base">
                                <i class="fa-solid fa-edit fa-sm sm:fa-sm mr-1"></i> Modifier
                                </Link>
                                <button @click="confirmDelete(movement.id)"
                                    class="action-btn bg-theme-red/10 hover:bg-theme-red text-[--theme-red] hover:text-theme-white text-sm sm:text-base">
                                    <i class="fa-solid fa-trash fa-sm sm:fa-sm mr-1"></i> Supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Liste des mouvements (cartes pour mobile) -->
            <div class="block sm:hidden space-y-4">
                <div v-for="(movement, index) in movements" :key="movement.id"
                    class="bg-theme-white p-4 rounded-lg shadow-md hover:shadow-xl transition-all duration-300"
                    :class="{ 'bg-theme-blue/5': index % 2 }">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm sm:text-base font-semibold"
                            :class="movement.type === 'entry' ? 'text-green-600' : 'text-[--theme-red]'">
                            {{ movement.type === 'entry' ? 'Entrée' : 'Sortie' }}
                        </span>
                        <span class="text-xs sm:text-sm text-theme-black">{{ movement.date }}</span>
                    </div>
                    <p class="text-sm sm:text-base text-theme-black font-semibold">Catégorie: {{ movement.category.name
                        }}</p>
                    <p class="text-sm sm:text-base text-theme-black font-semibold">Quantité: {{
                        Number(movement.quantity).toFixed(2) }}</p>
                    <p class="text-sm sm:text-base text-theme-black font-semibold">Valeur: {{
                        Number(movement.value).toFixed(2) }} FCFA</p>
                    <div class="mt-2 flex gap-2">
                        <Link :href="route('movements.edit', movement.id)"
                            class="action-btn bg-theme-blue/10 hover:bg-theme-blue text-theme-blue hover:text-theme-white text-xs sm:text-sm">
                        <i class="fa-solid fa-edit fa-xs sm:fa-sm mr-1"></i> Modifier
                        </Link>
                        <button @click="confirmDelete(movement.id)"
                            class="action-btn bg-theme-red/10 hover:bg-theme-red text-[--theme-red] hover:text-theme-white text-xs sm:text-sm">
                            <i class="fa-solid fa-trash fa-xs sm:fa-sm mr-1"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>