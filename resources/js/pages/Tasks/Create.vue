<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Mon planing journalier',
        href: '/tasks',
    },
    {
        title: 'Creer une tache',
        href: '/tasks/create',
    },
];
const form = useForm({
    title: '',
    description: '',
    date: '',
    time: '',
});

function submit() {
    form.post(route('tasks.store'), {
        onSuccess: () => form.reset(),
    });
}
</script><template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 py-8">
            <div class="w-full max-w-lg bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <h2 class="text-3xl font-bold text-theme-black mb-6 text-center">Créer une tâche</h2>
                <p class="text-gray-500 mb-8 text-center">Remplissez les informations ci-dessous pour ajouter une
                    nouvelle tâche.</p>
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-theme-black mb-1">Titre</label>
                        <input v-model="form.title" id="title" type="text" placeholder="Entrez le titre de la tâche"
                            class="border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-lg w-full p-3 text-theme-black transition" />
                        <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</div>
                    </div>
                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-theme-black mb-1">Description</label>
                        <textarea v-model="form.description" id="description" placeholder="Entrez une description"
                            rows="4"
                            class="border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-lg w-full p-3 text-theme-black transition"></textarea>
                        <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description
                            }}</div>
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-semibold text-theme-black mb-1">Date</label>
                        <input v-model="form.date" id="date" type="date"
                            class="border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-lg w-full p-3 text-theme-black transition" />
                        <div v-if="form.errors.date" class="text-red-600 text-sm mt-1">{{ form.errors.date }}</div>
                    </div>
                    <div>
                        <label for="time" class="block text-sm font-semibold text-theme-black mb-1">Heure</label>
                        <input v-model="form.time" id="time" type="time"
                            class="border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 rounded-lg w-full p-3 text-theme-black transition" />
                        <div v-if="form.errors.time" class="text-red-600 text-sm mt-1">{{ form.errors.time }}</div>
                    </div>
                    <button type="submit"
                        class="w-full py-3 px-6 rounded-lg bg-blue-600 text-white font-bold text-lg shadow-md hover:bg-blue-700 transition-all duration-200 active:scale-95">
                        Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
