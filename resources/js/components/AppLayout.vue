<template>
    <div class="bg-theme-white min-h-screen">
        <nav class="bg-theme-blue p-4 shadow">
            <div class="container mx-auto flex justify-between">
                <inertia-link :href="route('dashboard')" class="text-theme-white font-bold text-lg">
                    Task Manager
                </inertia-link>
                <div>
                    <inertia-link v-if="$page.props.auth.user" :href="route('tasks.index')"
                        class="text-theme-white mx-2">
                        Tasks
                    </inertia-link>
                    <inertia-link v-if="$page.props.auth.user" :href="route('logout')" method="post"
                        class="text-theme-white mx-2">
                        Logout
                    </inertia-link>
                    <inertia-link v-else :href="route('login')" class="text-theme-white mx-2">
                        Login
                    </inertia-link>
                    <inertia-link v-else :href="route('register')" class="text-theme-white mx-2">
                        Register
                    </inertia-link>
                </div>
            </div>
        </nav>
        <main class="container mx-auto p-4">
            <slot />
        </main>
    </div>
</template>

<script setup>
// import { InertiaLink } from '@inertiajs/vue3';
</script>