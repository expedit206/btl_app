<template>
    <AppLayout>
        <div class="container mx-auto p-4">
            <h2 class="text-2xl text-theme-black mb-4">Create Task</h2>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="title" class="block text-theme-black">Title</label>
                    <input v-model="form.title" id="title"
                        class="border border-theme-black rounded w-full p-2 text-theme-black" />
                    <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
                </div>
                <div class="mb-4">
                    <label for="priority" class="block text-theme-black">Priority</label>
                    <select v-model="form.priority" id="priority"
                        class="border border-theme-black rounded w-full p-2 text-theme-black">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary">Save</button>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../Components/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    priority: 'medium',
});

function submit() {
    form.post(route('tasks.store'), {
        onSuccess: () => form.reset(),
    });
}
</script>