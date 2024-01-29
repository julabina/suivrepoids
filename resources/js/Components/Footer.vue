<template>
    <footer class="flex items-center justify-center mx-auto mt-12 md:h-20 py-8 md:py-0 bg-primary text-white">
        <section class="flex flex-col-reverse md:flex-row items-center justify-between px-4 lg:px-0 lg:max-w-7xl w-full">
            <p class="text-sm font-light mt-8 md:mt-0 text-center md:text-left">Copyright © suivrepoids.fr - 2024</p>
            <nav class="flex flex-col md:flex-row">
                <!-- <Link :href="route('legals.about')" class="md:ml-5 text-center md:text-left hover:underline"><p>A propos</p></Link> -->
                <Link :href="route('legals.cgu')" class="md:ml-5 text-center md:text-left hover:underline font-semibold text-lg mb-2 md:font-normal md:text-base md:mb-0"><p>CGU</p></Link>
                <Link :href="route('legals.contact')" class="md:ml-5 text-center md:text-left hover:underline font-semibold text-lg mb-2 md:font-normal md:text-base md:mb-0"><p>Contact</p></Link>
            </nav>
        </section>
    </footer>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
</script>