<template>
    <div class="bg-theme-white border border-theme-black rounded p-4 shadow-md mb-4">
        <h3 class="text-lg font-bold text-theme-black">{{ task.title }}</h3>
        <p class="text-theme-black">{{ task.description }}</p>
        <p class="text-theme-black">Priority: <span :class="priorityClass">{{ task.priority }}</span></p>
        <p class="text-theme-black">Category: {{ task.category ? task.category.name : 'None' }}</p>
    </div>
</template>

<script setup>
defineProps({
    task: Object,
});

const priorityClass = computed(() => ({
    'text-red-600': task.priority === 'high',
    'text-yellow-600': task.priority === 'medium',
    'text-green-600': task.priority === 'low',
}));
</script>