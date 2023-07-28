
<template>
    <Head title="Accueil" />

    <AuthenticatedLayout>
        <template #header/>

        <section class="relative flex flex-col items-center justify-center bg-home-img bg-cover bg-center bg-no-repeat pb-16 h-screen">
            <h1  v-if="$page.props.auth.user" class="font-bold text-3xl mb-14 tracking-wide">Bienvenue <span class="first-letter:uppercase">{{ $page.props.auth.user.name }}</span></h1>
            <h1 v-else class="font-bold text-5xl mb-14 tracking-normal uppercase font-roboto">Suivez votre poids dès maintenant</h1>
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="w-2/6"><button class="btn-primary w-full py-2.5">Votre tableau de bord</button></Link>
            <div v-else class="flex">
                <Link :href="route('login')"><button class="btn-primary w-44 mx-6 py-2.5">Se connecter</button></Link>
                <Link :href="route('register')"><button class="btn-primary w-44 mx-6 py-2.5">Créer un compte</button></Link>
            </div>
            <Link href="#faq" class="absolute bottom-4 flex justify-center items-center border-2 border-black rounded-full w-12 h-12 transition-opacity hover:opacity-70 hover:transition-opacity">
                <i class="fa-solid fa-chevron-down text-xl"></i>
            </Link>
        </section>

        <section class="h-screen" id="faq">
            
        </section>

    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';


</script>
