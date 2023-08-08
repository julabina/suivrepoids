<template>
    <footer class="flex items-center justify-center mx-auto mt-12 h-20 bg-primary text-white">
        <section class="flex justify-between max-w-7xl w-full">
            <p class="text-sm font-light">Copyright © suivrepoids.fr - 2022</p>
            <nav class="flex">
                <Link :href="route('legals.about')" class="ml-5 hover:underline"><p>A propos</p></Link>
                <Link :href="route('legals.cgu')" class="ml-5 hover:underline"><p>CGU</p></Link>
                <Link :href="route('legals.contact')" class="ml-5 hover:underline"><p>Contact</p></Link>
            </nav>
        </section>
    </footer>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
</script>