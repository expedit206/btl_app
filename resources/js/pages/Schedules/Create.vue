<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Schedules',
        href: '/schedules',
    },
    {
        title: 'Create',
        href: '/schedules/create',
    },
];

const form = useForm({
    title: '',
    description: '',
    date: new Date().toISOString().split('T')[0],
    start_time: '',
    end_time: '',
    status: false,
});

function submit() {
    form.post(route('schedules.store'), {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>

    <Head title="Create Schedule" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="title" class="block text-theme-black">Title</label>
                            <input v-model="form.title" id="title"
                                class="border border-theme-black rounded w-full p-2 text-theme-black" />
                            <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
                        </div>
                        <div class="mb-4">
                            <label for="date" class="block text-theme-black">Date</label>
                            <input v-model="form.date" type="date" id="date"
                                class="border border-theme-black rounded w-full p-2 text-theme-black" />
                            <div v-if="form.errors.date" class="text-red-600">{{ form.errors.date }}</div>
                        </div>
                        <div class="mb-4">
                            <label for="start_time" class="block text-theme-black">Start Time</label>
                            <input v-model="form.start_time" type="time" id="start_time"
                                class="border border-theme-black rounded w-full p-2 text-theme-black" />
                            <div v-if="form.errors.start_time" class="text-red-600">{{ form.errors.start_time }}</div>
                        </div>
                        <div class="mb-4">
                            <label for="end_time" class="block text-theme-black">End Time</label>
                            <input v-model="form.end_time" type="time" id="end_time"
                                class="border border-theme-black rounded w-full p-2 text-theme-black" />
                            <div v-if="form.errors.end_time" class="text-red-600">{{ form.errors.end_time }}</div>
                        </div>
                        <button type="submit" class="btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>