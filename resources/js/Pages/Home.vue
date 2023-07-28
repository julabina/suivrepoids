
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

        <section id="faq" class="flex items-center justify-center py-28 w-full bg-gray-200">
            <div class="relative w-96 h-96 bg-primary px-8 py-11 mr-4 text-white">
                <h2 class="font-bold text-4xl mb-8">Comment ca marche ?</h2>
                <p class="leading-6 tracking-wide">Suivrepoids.fr vous permet d'enregistrer régulièrement votre poids et de générer l'IMC et l'IMG automatiquement, vous pouvez suivre votre progression et réaliser vos objectifs.</p>
                <Link :href="$page.props.auth.user ? route('dashboard') : route('register')" class="absolute flex justify-center bottom-10 left-0 right-0"><button class="btn-primary bg-primary2 p-2 transition-colors hover:opacity-100 hover:bg-white hover:text-primary hover:transition-colors">Commencer</button></Link>
            </div>
            <div class="flex flex-col justify-around items-center w-64 h-80 px-6 pt-7 pb-8 bg-white mx-4 transition-transform hover:transition-transform hover:scale-110">
                <i class="text-4xl text-primary fa-solid fa-weight-scale"></i>
                <h3 class="font-semibold">Atteindre votre objectif</h3>
                <p class="leading-6 tracking-wide text-center">Choisissez un objectif, puis observer votre évolution.</p>
            </div>
            <div class="flex flex-col justify-around items-center w-64 h-80 px-6 pt-7 pb-8 bg-white mx-4 transition-transform hover:transition-transform hover:scale-110">
                <i class="text-4xl text-primary fa-solid fa-chart-line"></i>
                <h3 class="font-semibold">Suivre votre poids</h3>
                <p class="leading-6 tracking-wide text-center">Entrez votre poids et suivez la progression de celui-ci.</p>
            </div>
            <div class="flex flex-col justify-around items-center w-64 h-80 px-6 pt-7 pb-8 bg-white ml-4 transition-transform hover:transition-transform hover:scale-110">
                <i class="text-4xl text-primary fa-solid fa-euro-sign"></i>
                <h3 class="font-semibold">100% Gratuit</h3>
                <p class="leading-6 tracking-wide text-center">Suivrepoids.fr est entièrement gratuit et le restera.</p>
            </div>
        </section>

        <section>
            
        </section>
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';


</script>
