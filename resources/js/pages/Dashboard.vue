<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { Movement, BreadcrumbItemType } from '@/types';
import { Bar, Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
} from 'chart.js';

// Enregistrer les composants Chart.js
ChartJS.register(Title, Tooltip, Legend, BarElement, LineElement, CategoryScale, LinearScale, PointElement);

const props = defineProps<{
    movements: Movement[];
}>();

const breadcrumbs: BreadcrumbItemType[] = [
    { title: 'Dashboard', href: '/dashboard' },
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

// Préparation des données pour les graphiques
const groupByMonth = (movements: Movement[]) => {
    const months: { [key: string]: { entries: number; exits: number } } = {};
    movements.forEach((m) => {
        const date = new Date(m.date);
        const monthKey = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        if (!months[monthKey]) {
            months[monthKey] = { entries: 0, exits: 0 };
        }
        if (m.type === 'entry') {
            months[monthKey].entries += Number(m.value);
        } else {
            months[monthKey].exits += Number(m.value);
        }
    });
    return months;
};

const chartData = computed(() => {
    const grouped = groupByMonth(props.movements);
    const labels = Object.keys(grouped).sort();
    const entries = labels.map((month) => grouped[month].entries);
    const exits = labels.map((month) => grouped[month].exits);
    return {
        labels,
        datasets: [
            {
                label: 'Entrées (€)',
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                data: entries,
            },
            {
                label: 'Sorties (€)',
                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                data: exits,
            },
        ],
    };
});

const netChartData = computed(() => {
    const grouped = groupByMonth(props.movements);
    const labels = Object.keys(grouped).sort();
    const netValues = labels.map((month) => grouped[month].entries - grouped[month].exits);
    return {
        labels,
        datasets: [
            {
                label: 'Solde net (€)',
                borderColor: 'rgba(99, 102, 241, 1)',
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                data: netValues,
                fill: true,
            },
        ],
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { position: 'top' },
        title: { display: true },
    },
};
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Tableau de bord</h1>

            <!-- Résumé financier -->
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

            <!-- Visualisations -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Visualisations</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Entrées vs Sorties par mois</h3>
                        <div class="h-64">
                            <Bar :data="chartData"
                                :options="{ ...chartOptions, plugins: { title: { text: 'Entrées et Sorties' } } }" />
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-medium text-gray-700 mb-2">Solde net par mois</h3>
                        <div class="h-64">
                            <Line :data="netChartData"
                                :options="{ ...chartOptions, plugins: { title: { text: 'Solde Net' } } }" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>