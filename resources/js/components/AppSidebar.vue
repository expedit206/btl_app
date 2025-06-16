<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    // {
    //     title: 'schedule',
    //     href: '/schedules',
    //     icon: LayoutGrid, // Change l'icône si tu veux
    // },
    // {
    //     title: 'Add schedule',
    //     href: '/schedules/create',
    //     icon: LayoutGrid, // Change l'icône si tu veux
    // },
    {
        title: 'Tasks',
        href: '/tasks',
        icon: LayoutGrid, // Change l'icône si tu veux
    },
    {
        title: 'Create Task',
        href: '/tasks/create',
        icon: LayoutGrid, // Change l'icône si tu veux
    },
    // {
    //     title: 'Categories',
    //     href: '/categories',
    //     icon: LayoutGrid, // Change l'icône si tu veux
    // },
    // {
    //     title: 'Create Category',
    //     href: '/categories/create',
    //     icon: LayoutGrid, // Change l'icône si tu veux
    // },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Github Repo',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits',
    //     icon: BookOpen,
    // },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
