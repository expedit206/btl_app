<template>
    <AppLayout>
        <div class="container mx-auto p-4">
            <h2 class="text-2xl text-theme-black mb-4">My Tasks</h2>
            <p v-if="$page.props.flash.success" class="text-green-600 mb-4">{{ $page.props.flash.success }}</p>
            <div class="grid gap-4">
                <TaskCard v-for="task in tasks" :key="task.id" :task="task" />
            </div>
            <inertia-link :href="route('tasks.create')" class="btn-primary mt-4 inline-block">
                Add Task
            </inertia-link>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../Components/AppLayout.vue';
import TaskCard from '../Components/TaskCard.vue';
import { InertiaLink } from '@inertiajs/vue3';

defineProps({
    tasks: Array,
});
</script>