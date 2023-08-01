<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import HeaderMenu from '@/Components/HeaderMenu.vue';
import Footer from '@/Components/Footer.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
    
            <!-- Page Heading -->
            <header class="fixed top-0 z-50 w-full shadow-xl h-16 bg-white" v-if="$slots.header">
                <!-- <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    
                </div> -->
                <slot name="header" />
                <HeaderMenu/>
            </header>

            <!-- Page Content -->
            <main class="min-h-screen">
                <slot />
            </main>
            <Footer/>
        </div>
    </div>
</template>
