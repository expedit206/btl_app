<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto px-6 py-8">
            <h2 class="text-3xl font-semibold text-theme-black mb-6">Modifier une tâche</h2>
            <form @submit.prevent="submit" class="max-w-lg">
                <div class="mb-5">
                    <label for="title" class="block text-theme-black font-medium mb-2">Titre</label>
                    <input v-model="form.title" id="title"
                        class="border border-theme-black rounded-lg w-full px-4 py-2 text-theme-black focus:ring-2 focus:ring-theme-blue focus:border-theme-blue transition duration-200" />
                    <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</div>
                </div>
                <div class="mb-5">
                    <label for="description" class="block text-theme-black font-medium mb-2">Description</label>
                    <textarea v-model="form.description" id="description"
                        class="border border-theme-black rounded-lg w-full px-4 py-2 text-theme-black focus:ring-2 focus:ring-theme-blue focus:border-theme-blue transition duration-200"
                        rows="4"></textarea>
                    <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}
                    </div>
                </div>
                <div class="mb-5">
                    <label for="date" class="block text-theme-black font-medium mb-2">Date</label>
                    <input v-model="form.date" type="date" id="date"
                        class="border border-theme-black rounded-lg w-full px-4 py-2 text-theme-black focus:ring-2 focus:ring-theme-blue focus:border-theme-blue transition duration-200" />
                    <div v-if="form.errors.date" class="text-red-600 text-sm mt-1">{{ form.errors.date }}</div>
                </div>
                <div class="mb-5">
                    <label for="time" class="block text-theme-black font-medium mb-2">Heure</label>
                    <input v-model="form.time" type="time" id="time"
                        class="border border-theme-black rounded-lg w-full px-4 py-2 text-theme-black focus:ring-2 focus:ring-theme-blue focus:border-theme-blue transition duration-200" />
                    <div v-if="form.errors.time" class="text-red-600 text-sm mt-1">{{ form.errors.time }}</div>
                </div>
                <div class="mb-5">
                    <label for="status" class="block text-theme-black font-medium mb-2">Statut</label>
                    <input v-model="form.status" type="checkbox" id="status"
                        class="h-5 w-5 text-theme-blue focus:ring-theme-blue border-theme-black rounded" />
                    <span class="ml-2 text-theme-black text-sm">{{ form.status ? 'Complétée' : 'En cours' }}</span>
                    <div v-if="form.errors.status" class="text-red-600 text-sm mt-1">{{ form.errors.status }}</div>
                </div>
                <button type="submit" class="btn-primary">Enregistrer</button>
            </form>
        </div>
    </AppLayout>
</template>

  <script setup  lang="ts">
  import AppLayout from '@/layouts/AppLayout.vue';
  import { useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Mon planing journalier',
        href: '/tasks',
    },
    {
        title: 'modifier la tache',
        href: '/tasks/edit',
    },
];
  const props = defineProps({
      task: Object,
  });

  const form = useForm({
      title: props.task.title,
      description: props.task.description,
      date: props.task.date,
      time: props.task.time,
      status: props.task.status,
  });

  function submit() {
      form.put(route('tasks.update', props.task.id), {
          onSuccess: () => form.reset(),
      });
  } 
  </script>