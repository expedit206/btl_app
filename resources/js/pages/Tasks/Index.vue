<template>
      <AppLayout :breadcrumbs="breadcrumbs">
          <Head title="Taches" />
          <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
              <h2 class="text-2xl sm:text-3xl font-semibold text-theme-black mb-6 flex items-center">
                  <svg class="w-6 h-6 sm:w-8 sm:h-8 mr-2 text-theme-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Planning des tâches
              </h2>
              <p v-if="$page.props.flash.success" class="text-green-600 bg-green-100 border border-green-300 rounded px-4 py-2 mb-6 animate-fade-in">{{ $page.props.flash.success }}</p>
              <div class="mb-6 max-w-xs sm:max-w-md">
                  <label for="dateFilter" class="block text-theme-black font-medium mb-2 text-sm sm:text-base">Filtrer par date :</label>
                  <input
                      v-model="form.dateFilter"
                      type="date"
                      id="dateFilter"
                      class="border border-theme-black rounded-lg w-full px-3 py-2 text-theme-black text-sm sm:text-base focus:ring-2 focus:ring-theme-blue focus:border-theme-blue transition duration-200"
                  />
              </div>

              <!-- Tâches manquées des jours précédents -->
              <h3 class="text-xl sm:text-2xl font-medium text-theme-black mb-4 flex items-center">
                  <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Tâches manquées des jours précédents
              </h3>
              <div class="grid grid-cols-1 gap-4 sm:gap-6 mb-10">
                  <div v-for="task in missedTasks" :key="task.id" class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 sm:p-5 shadow-md hover:shadow-lg transition-shadow duration-200 flex flex-col sm:flex-row items-start justify-between">
                      <div class="flex items-start flex-1 mb-4 sm:mb-0">
                          <div class="flex-shrink-0">
                              <input
                                  type="checkbox"
                                  :checked="task.status"
                                  @change="toggleTask(task.id, !task.status)"
                                  class="custom-checkbox"
                              />
                          </div>
                          <div class="ml-3 sm:ml-4">
                              <h4 class="text-base sm:text-lg font-semibold text-theme-black">{{ task.title }}</h4>
                              <p class="text-theme-black text-xs sm:text-sm mt-1">{{ task.description }}</p>
                              <div class="mt-2 flex flex-wrap items-center gap-2">
                                  <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-200 text-red-700 rounded">Manquée</span>
                                  <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-theme-black rounded">Date : {{ task.date }}</span>
                                  <span v-if="task.time" class="inline-block px-2 py-1 text-xs font-medium bg-theme-blue text-theme-white rounded">à {{ task.time }}</span>
                              </div>
                          </div>
                      </div>
                      <div class="flex flex-col sm:flex-row gap-2 sm:gap-2 w-full sm:w-auto">
                          <TextLink :href="route('tasks.edit', task.id)" class="btn btn-secondary text-xs sm:text-sm text-center">Modifier</TextLink>
                          <button @click="deleteTask(task.id)" class="btn btn-danger text-xs sm:text-sm">Supprimer</button>
                      </div>
                  </div>
                  <p v-if="!missedTasks.length" class="text-theme-black text-sm italic pl-5">Aucune tâche manquée.</p>
              </div>

              <!-- Tâches en cours -->
              <h3 class="text-xl sm:text-2xl font-medium text-theme-black mb-4 flex items-center">
                  <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-theme-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                  Tâches du jour
              </h3>
              <div class="grid grid-cols-1  gap-4 sm:gap-6 mb-10">
                  <div v-for="task in pendingTasks" :key="task.id" class="bg-theme-white border-l-4 border-theme-blue rounded-lg p-4 sm:p-5 shadow-md hover:shadow-lg transition-shadow duration-200 flex flex-col sm:flex-row items-start justify-between">
                      <div class="flex items-start flex-1 mb-4 sm:mb-0">
                          <div class="flex-shrink-0">
                              <input
                                  type="checkbox"
                                  :checked="task.status"
                                  @change="toggleTask(task.id, !task.status)"
                                  class="custom-checkbox"
                              />
                          </div>
                          <div class="ml-3 sm:ml-4">
                              <h4 class="text-base sm:text-lg font-semibold text-theme-black">{{ task.title }}</h4>
                              <p class="text-theme-black text-xs sm:text-sm mt-1">{{ task.description }}</p>
                              <div class="mt-2 flex flex-wrap items-center gap-2">
                                  <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-theme-black rounded">Date : {{ task.date }}</span>
                                  <span v-if="task.time" class="inline-block px-2 py-1 text-xs font-medium bg-theme-blue text-theme-white rounded">à {{ task.time }}</span>
                              </div>
                          </div>
                      </div>
                      <div class="flex flex-col sm:flex-row gap-2 sm:gap-2 w-full sm:w-auto">
                          <TextLink :href="route('tasks.edit', task.id)" class="btn btn-secondary text-xs sm:text-sm text-center">Modifier</TextLink>
                          <button @click="deleteTask(task.id)" class="btn btn-danger text-xs sm:text-sm">Supprimer</button>
                      </div>
                  </div>
                  <p v-if="!pendingTasks.length" class="text-theme-black text-sm italic pl-5">Aucune tâche en cours.</p>
              </div>

              <!-- Tâches accomplies -->
              <h3 class="text-xl sm:text-2xl font-medium text-theme-black mb-4 flex items-center">
                  <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                  Tâches accomplies
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                  <div v-for="task in completedTasks" :key="task.id" class="bg-theme-white border-l-4 border-green-500 rounded-lg p-4 sm:p-5 shadow-md hover:shadow-lg transition-shadow duration-200 flex flex-col sm:flex-row items-start justify-between">
                      <div class="flex items-start flex-1 mb-4 sm:mb-0">
                          <div class="flex-shrink-0">
                              <input
                                  type="checkbox"
                                  :checked="task.status"
                                  @change="toggleTask(task.id, !task.status)"
                                  class="custom-checkbox"
                              />
                          </div>
                          <div class="ml-3 sm:ml-4">
                              <h4 class="text-base sm:text-lg font-semibold text-theme-black line-through">{{ task.title }}</h4>
                              <p class="text-theme-black text-xs sm:text-sm mt-1">{{ task.description }}</p>
                              <div class="mt-2 flex flex-wrap items-center gap-2">
                                  <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-theme-black rounded">Date : {{ task.date }}</span>
                                  <span v-if="task.time" class="inline-block px-2 py-1 text-xs font-medium bg-theme-blue text-theme-white rounded">à {{ task.time }}</span>
                              </div>
                          </div>
                      </div>
                      <div class="flex flex-col sm:flex-row gap-2 sm:gap-2 w-full sm:w-auto">
                          <TextLink :href="route('tasks.edit', task.id)" class="btn btn-secondary text-xs text-center sm:text-sm">Modifier</TextLink>
                          <button @click="deleteTask(task.id)" class="btn btn-danger text-xs sm:text-sm">Supprimer</button>
                      </div>
                  </div>
                  <p v-if="!completedTasks.length" class="text-theme-black text-sm italic pl-5">Aucune tâche accomplie.</p>
              </div>

              <TextLink :href="route('tasks.create')" class="btn-primary mt-6 inline-block text-sm sm:text-base">Ajouter une tâche</TextLink>
          </div>
      </AppLayout>
  </template>

  <script setup lang="ts">
  import TextLink from '@/components/TextLink.vue';
  import AppLayout from '@/layouts/AppLayout.vue';
  import { useForm } from '@inertiajs/vue3';
  import { computed } from 'vue';
  import { Head } from '@inertiajs/vue3';
  import { type BreadcrumbItem } from '@/types';

  const breadcrumbs: BreadcrumbItem[] = [
      {
          title: 'les taches',
          href: '/tasks/create',
      },
  ];

  const props = defineProps<{
      tasks: Array<any>;
      selectedDate: string;
  }>();

  const form = useForm({
      dateFilter: props.selectedDate,
  });

  const today = new Date().toISOString().split('T')[0];

  const missedTasks = computed(() => props.tasks.filter(task => !task.status && task.date < today));
  const pendingTasks = computed(() => props.tasks.filter(task => !task.status && task.date === form.dateFilter));
  const completedTasks = computed(() => props.tasks.filter(task => task.status && task.date === form.dateFilter));

  function filterTasks() {
      form.get(route('tasks.index'), {
          preserveState: true,
          preserveScroll: true,
      });
  }

  function toggleTask(taskId: number, status: boolean) {
      const toggleForm = useForm({ status });
      toggleForm.patch(route('tasks.update', taskId), {
          preserveState: true,
          preserveScroll: true,
      });
  }

  function deleteTask(taskId: number) {
      if (confirm('Voulez-vous supprimer cette tâche ?')) {
          const deleteForm = useForm({});
          deleteForm.delete(route('tasks.destroy', taskId), {
              preserveState: true,
              preserveScroll: true,
          });
      }
  }
  </script>