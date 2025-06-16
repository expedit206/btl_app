<template>
    <AppLayout>
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-3xl font-semibold text-theme-black mb-6">Planning des tâches</h2>
            <p v-if="$page.props.flash.success"
                class="text-green-600 bg-green-100 border border-green-300 rounded px-4 py-2 mb-6 animate-fade-in">{{
                    $page.props.flash.success }}</p>
            <div class="mb-6 max-w-md">
                <label for="dateFilter" class="block text-theme-black font-medium mb-2">Filtrer par date :</label>
                <input v-model="form.dateFilter" type="date" id="dateFilter"
                    class="border border-theme-black rounded-lg w-full px-4 py-2 text-theme-black focus:ring-2 focus:ring-theme-blue focus:border-theme-blue transition duration-200"
                    @change="filterTasks" />
            </div>

            <!-- Tâches en cours -->
            <h3 class="text-2xl font-medium text-theme-black mb-4">Tâches en cours</h3>
            <div class="grid gap-4 mb-10">
                <div v-for="task in pendingTasks" :key="task.id"
                    class="bg-theme-white border border-theme-black rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-start justify-between">
                    <div class="flex items-start flex-1">
                        <input type="checkbox" :checked="task.status" @change="toggleTask(task.id, !task.status)"
                            class="mr-3 mt-1 h-5 w-5 text-theme-blue focus:ring-theme-blue border-theme-black rounded" />
                        <div>
                            <h4 class="text-lg font-semibold text-theme-black">{{ task.title }}</h4>
                            <p class="text-theme-black text-sm">{{ task.description }}</p>
                            <p class="text-theme-black text-sm font-medium">Date : {{ task.date }} <span
                                    v-if="task.time">à {{ task.time }}</span></p>
                        </div>
                    </div>
                    <TextLink :href="route('tasks.edit', task.id)"
                        class="text-theme-blue hover:text-theme-blue-dark text-sm font-medium transition-colors duration-200">Modifier</TextLink>
                </div>
                <p v-if="!pendingTasks.length" class="text-theme-black text-sm italic">Aucune tâche en cours.</p>
            </div>

            <!-- Tâches accomplies -->
            <h3 class="text-2xl font-medium text-theme-black mb-4">Tâches accomplies</h3>
            <div class="grid gap-4">
                <div v-for="task in completedTasks" :key="task.id"
                    class="bg-theme-white border border-theme-black rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-start justify-between">
                    <div class="flex items-start flex-1">
                        <input type="checkbox" :checked="task.status" @change="toggleTask(task.id, !task.status)"
                            class="mr-3 mt-1 h-5 w-5 text-theme-blue focus:ring-theme-blue border-theme-black rounded" />
                        <div>
                            <h4 class="text-lg font-semibold text-theme-black line-through">{{ task.title }}</h4>
                            <p class="text-theme-black text-sm">{{ task.description }}</p>
                            <p class="text-theme-black text-sm font-medium">Date : {{ task.date }} <span
                                    v-if="task.time">à {{ task.time }}</span></p>
                        </div>
                    </div>
                    <div class="space-x-4">
                        <inertia-link :href="route('tasks.edit', task.id)"
                            class="text-theme-blue hover:text-theme-blue-dark text-sm font-medium transition-colors duration-200">Modifier</inertia-link>
                        <button @click="deleteTask(task.id)"
                            class="text-red-600 hover:text-red-800 text-sm font-medium transition-colors duration-200">Supprimer</button>
                    </div>
                </div>
                <p v-if="!completedTasks.length" class="text-theme-black text-sm italic">Aucune tâche accomplie.</p>
            </div>

            <TextLink :href="route('tasks.create')" class="btn-primary mt-6 inline-block">Ajouter une
                tâche</TextLink>
        </div>
    </AppLayout>
</template>

<script setup>
import TextLink from '@/components/TextLink.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    tasks: Array,
    selectedDate: String,
});

const form = useForm({
    dateFilter: props.selectedDate,
});

const pendingTasks = computed(() => props.tasks.filter(task => !task.status));
const completedTasks = computed(() => props.tasks.filter(task => task.status));

function filterTasks() {
    form.get(route('tasks.index'), {
        preserveState: true,
        preserveScroll: true,
    });
}

function toggleTask(taskId, status) {
    const toggleForm = useForm({ status });
    toggleForm.patch(route('tasks.update', taskId), {
        preserveState: true,
        preserveScroll: true,
    });
}

function deleteTask(taskId) {
    if (confirm('Voulez-vous supprimer cette tâche ?')) {
        const deleteForm = useForm({});
        deleteForm.delete(route('tasks.destroy', taskId), {
            preserveState: true,
            preserveScroll: true,
        });
    }
}
</script>