<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { usePage } from '@inertiajs/vue3';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const successMessage = page.props.flash?.success;
</script>

<template>
    <AppSidebarLayout :breadcrumbs="breadcrumbs">
        <!-- Notification -->
        <div v-if="successMessage"
            class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-4 mt-4 rounded-md max-w-2xl">
            {{ successMessage }}
        </div>

        <!-- Contenu principal -->
        <slot />
    </AppSidebarLayout>
</template>