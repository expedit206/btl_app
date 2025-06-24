<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Home, List, Plus, ArrowLeftRight, CheckSquare, BookOpen } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Tableau de bord',
        href: '/dashboard',
        icon: Home,
    },
    {
        title: 'Catégories',
        href: '/categories',
        icon: List,
    },
    {
        title: 'Créer une catégorie',
        href: '/categories/create',
        icon: Plus,
    },
    {
        title: 'Mouvements',
        href: '/movements',
        icon: ArrowLeftRight,
    },
    {
        title: 'Créer un mouvement',
        href: '/movements/create',
        icon: Plus,
    },
    {
        title: 'Tâches',
        href: '/tasks',
        icon: CheckSquare,
    },
    {
        title: 'Créer une tâche',
        href: '/tasks/create',
        icon: Plus,
    },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Dépôt GitHub',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: GitHub,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits',
    //     icon: BookOpen,
    // },
];
</script>

<template>
    <div class="flex min-h-screen bg-blue-500">
        <Sidebar collapsible="icon" variant="inset" class="bg-theme-white text-theme-black">
            <SidebarHeader class="border-b border-theme-black/10">
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" as-child class="hover:bg-theme-blue/10">
                            <Link :href="route('dashboard')" class="text-white">
                            <AppLogo class="w-10 h-10 lg:w-12 lg:h-12 text-theme-blue" />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain :items="mainNavItems" />
            </SidebarContent>

            <SidebarFooter class="border-t border-theme-black/10">
                <NavFooter :items="footerNavItems" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
        <main class="flex-1">
            <slot />
        </main>
    </div>
</template>