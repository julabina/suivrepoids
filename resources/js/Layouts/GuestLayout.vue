<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            
        </div>

        <div
            class="bg-white w-80 px-8 py-10 rounded shadow-xl"
        >
            <slot />
        </div>
    </div>
    <Footer/>
</template>
