
<template>
    <Head title="Accueil" />

    <AuthenticatedLayout>
        <template #header/>

        <section class="relative flex flex-col items-center justify-center bg-home-img bg-cover bg-center bg-no-repeat pb-16 h-screen">
            <h1  v-if="$page.props.auth.user" class="font-bold text-3xl mb-14 tracking-wide">Bienvenue <span class="first-letter:uppercase">{{ $page.props.auth.user.name }}</span></h1>
            <h1 v-else class="font-bold md:text-5xl mb-14 tracking-normal text-center text-4xl uppercase font-roboto">Suivez votre poids dès maintenant</h1>
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="w-full px-4 sm:w-[600px]"><button class="btn-primary w-full py-5 lg:py-2.5">Votre tableau de bord</button></Link>
            <div v-else class="flex flex-col md:flex-row">
                <Link :href="route('login')"><button class="btn-primary w-44 mb-8 md:mb-0 mx-6 py-5 lg:py-2.5">Se connecter</button></Link>
                <Link :href="route('register')"><button class="btn-primary w-44 mx-6 py-5 lg:py-2.5">Créer un compte</button></Link>
            </div>
            <Link href="#faq" class="absolute bottom-4 flex justify-center items-center border-2 border-black rounded-full w-12 h-12 transition-opacity hover:opacity-70 hover:transition-opacity">
                <i class="fa-solid fa-chevron-down text-xl"></i>
            </Link>
        </section>

        <section id="faq" class="flex flex-col xl:flex-row items-center justify-center py-28 w-full bg-gray-200">
            <div class="relative sm:w-96 sm:h-96 bg-primary px-8 py-11 lg:mr-4 text-white mb-8 xl:mb-0">
                <h2 class="font-bold text-4xl mb-8">Comment ca marche ?</h2>
                <p class="leading-6 tracking-wide">Suivrepoids.fr vous permet d'enregistrer régulièrement votre poids et de générer l'IMC et l'IMG automatiquement, vous pouvez suivre votre progression et réaliser vos objectifs.</p>
                <Link :href="$page.props.auth.user ? route('dashboard') : route('register')" class="sm:absolute flex justify-center mt-10 xs:mt-0 bottom-10 left-0 right-0"><button class="btn-primary bg-primary2 p-4 md:p-2 transition-colors hover:opacity-100 hover:bg-white hover:text-primary hover:transition-colors">Commencer</button></Link>
            </div>
            <div class="flex flex-col lg:flex-row items-center w-full sm:w-auto">
                <div class="flex flex-col justify-around items-center xs:w-96 sm:w-64 h-80 px-6 pt-7 pb-8 bg-white mb-6 lg:mb-0 mx-4 transition-transform hover:transition-transform hover:scale-110">
                    <i class="text-4xl text-primary fa-solid fa-weight-scale"></i>
                    <h3 class="font-semibold">Atteindre votre objectif</h3>
                    <p class="leading-6 tracking-wide text-center">Choisissez un objectif, puis observer votre évolution.</p>
                </div>
                <div class="flex flex-col justify-around items-center xs:w-96 sm:w-64 h-80 px-6 pt-7 pb-8 bg-white mb-6 lg:mb-0 mx-4 transition-transform hover:transition-transform hover:scale-110">
                    <i class="text-4xl text-primary fa-solid fa-chart-line"></i>
                    <h3 class="font-semibold">Suivre votre poids</h3>
                    <p class="leading-6 tracking-wide text-center">Entrez votre poids et suivez la progression de celui-ci.</p>
                </div>
                <div class="flex flex-col justify-around items-center xs:w-96 sm:w-64 h-80 px-6 pt-7 pb-8 bg-white mb-6 lg:mb-0 lg:ml-4 transition-transform hover:transition-transform hover:scale-110">
                    <i class="text-4xl text-primary fa-solid fa-euro-sign"></i>
                    <h3 class="font-semibold">100% Gratuit</h3>
                    <p class="leading-6 tracking-wide text-center">Suivrepoids.fr est entièrement gratuit et le restera.</p>
                </div>
            </div>
        </section>

        <section class="flex flex-col items-center py-8">
            <h2 class="subtitle mt-12 mb-24 xl:mb-16">Calculer votre IMC et votre IMG</h2>
            <div class="flex flex-col xl:flex-row items-center justify-between px-8 md:px-0 mb-16 xl:mb-10">
                <div class="w-full md:w-[700px] xl:w-[900px] font-normal text-lg xl:text-base mb-12 xl:mb-0 leading-6 tracking-wide">
                    <p class="mb-2.5">L'indice de masse corporelle permet de rapidement évaluer votre corpulence avec votre poids et votre taille indépendamment de votre sexe.</p>
                    <p>Pour connaitre le votre, rien de plus simple, il vous suffit de cliquer sur 'Calculer votre IMC'.</p>
                </div>
                <Link :href="route('calcul.bmi')" class="flex justify-center items-center w-full md:w-64 h-20 xl:w-36 xl:h-36 xl:ml-24 p-4 text-center text-lg xl:text-base border-1 border-black font-semibold bg-gray-200 border xl:border-gray-200 rounded transition-colors hover:transition-colors hover:bg-white hover:border-black">Calculer votre IMC</Link>
            </div>
            <div class="flex flex-col xl:flex-row items-center justify-between px-8 md:px-0 mb-2 md:mb-10">
                <div class="w-full md:w-[700px] xl:w-[900px] font-normal text-lg xl:text-base mb-12 xl:mb-0 leading-6 tracking-wide">
                    <p class="mb-2.5">L'indice de masse grasse permet de définir la proportion de graisse dans le corps.</p>
                    <p>Pour connaitre le votre, rien de plus simple, il vous suffit de cliquer sur 'Calculer votre IMG'.</p>
                </div>
                <Link :href="route('calcul.bfp')" class="flex justify-center items-center w-full md:w-64 h-20 xl:w-36 xl:h-36 xl:ml-24 p-4 text-center text-lg xl:text-base border-1 border-black font-semibold bg-gray-200 border xl:border-gray-200 rounded transition-colors hover:transition-colors hover:bg-white hover:border-black">Calculer votre IMG</Link>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';


</script>
