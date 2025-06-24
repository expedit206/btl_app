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
                label: 'Entrées (FCFA)',
                backgroundColor: 'rgba(37, 99, 235, 0.5)', // --theme-blue
                borderColor: '#2563EB',
                data: entries,
            },
            {
                label: 'Sorties (FCFA)',
                backgroundColor: 'rgba(220, 38, 38, 0.5)', // --theme-red
                borderColor: '#DC2626',
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
                label: 'Solde net (FCFA)',
                borderColor: '#1E40AF', // --theme-blue-dark
                backgroundColor: 'rgba(30, 64, 175, 0.2)',
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
        <div class="p-4 sm:p-6 lg:p-8 bg-theme-white min-h-screen">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-theme-black mb-6">Tableau de bord</h1>

            <!-- Résumé financier -->
            <div class="mb-6">
                <h2 class="text-xl lg:text-2xl font-semibold text-theme-black mb-4">Résumé financier</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-6">
                    <div
                        class="bg-theme-black p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 border border-theme-black/10">
                        <h3 class="text-base sm:text-lg font-medium text-theme-white">Total des entrées</h3>
                        <p class="text-xl sm:text-2xl text-theme-blue">{{ totalEntries.toFixed(2) }} FCFA</p>
                    </div>
                    <div
                        class="bg-theme-blue p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 border border-theme-black/10">
                        <h3 class="text-base sm:text-lg font-medium text-theme-white">Total des sorties</h3>
                        <p class="text-xl sm:text-2xl text-[--theme-red]">{{ totalExits.toFixed(2) }} FCFA</p>
                    </div>
                    <div
                        class="bg-slate-400 p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 border border-theme-black/10">
                        <h3 class="text-base sm:text-lg font-medium text-theme-white">Solde net</h3>
                        <p class="text-xl sm:text-2xl"
                            :class="net >= 0 ? 'text-theme-blue-dark' : 'text-[--theme-red]'">
                            {{ net.toFixed(2) }} FCFA
                        </p>
                    </div>
                </div>
            </div>

            <!-- Visualisations -->
            <div class="mb-6">
                <h2 class="text-xl lg:text-2xl font-semibold text-theme-black mb-4">Visualisations</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-theme-white p-4 rounded-lg shadow-md border border-theme-black/10">
                        <h3 class="text-lg font-medium text-theme-black mb-2">Entrées vs Sorties par mois</h3>
                        <div class="h-64">
                            <Bar :data="chartData"
                                :options="{ ...chartOptions, plugins: { title: { text: 'Entrées et Sorties' } } }" />
                        </div>
                    </div>
                    <div class="bg-theme-white p-4 rounded-lg shadow-md border border-theme-black/10">
                        <h3 class="text-lg font-medium text-theme-black mb-2">Solde net par mois</h3>
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