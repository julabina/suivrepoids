<template>
    <div v-if="windowsWidth > 767" class="flex justify-between max-w-7xl mx-auto h-full px-8">
        <Link :href="route('home')"><section class="flex items-center h-full">
            <img src="../../assets/weight-icon.jpg" alt="app icon" class="h-5 mr-1.5">
            <h1 class="uppercase font-semibold text-2xl">Suivrepoids.fr</h1>
        </section></Link>
        <section v-if="$page.props.auth.user" class="flex items-center">
            <Link v-if="calculPage === 'bmi'" :href="route('calcul.bfp')" method="get"><button class="font-roboto font-semibold px-3 text-base h-8 mr-3">IMG</button></Link>
            <Link v-if="calculPage === 'bfp'" :href="route('calcul.bmi')" method="get"><button class="font-roboto font-semibold px-3 text-base h-8 mr-3">IMC</button></Link>
            <Link v-if="calculPage !== null" :href="route('dashboard')" method="get"><button class="btn-primary py-1.5 px-3 text-sm h-8 mr-3">Tableau de bord</button></Link>
            <Link :href="route('logout')" method="post"><button class="btn-primary py-1.5 px-3 text-sm h-8">Se deconnecter</button></Link>
            <Link :href="route('profile.edit')"><button class="flex justify-center items-center bg-primary rounded-full w-8 h-8 ml-3.5 transition-opacity hover:transition-opacity hover:opacity-80"><i class="fa-solid fa-user text-white text-[16px]" ></i></button></Link>
        </section>
        <section v-else class="flex items-center">
            <Link :href="route('login')"><button class="btn-primary bg-white text-black py-1.5 px-3 text-sm">Se connecter</button></Link>
            <Link :href="route('register')"><button class="btn-primary py-1.5 px-3 text-sm">Créer un compte</button></Link>
        </section>
    </div>
    <div v-else class="w-full">
        <i @click="toggleMobileMenu = true" v-if="toggleMobileMenu === false" class="fa-solid fa-bars text-5xl mt-2 ml-3.5" ></i>
        <div v-else class="fixed top-0 right-0 left-0 bottom-0 flex flex-col items-center bg-white">
            <i @click="toggleMobileMenu = false" class="fa-solid fa-xmark fixed text-6xl top-1 left-3.5" ></i>
            <Link :href="route('home')"><section class="flex items-center mt-20 mb-16">
                <img src="../../assets/weight-icon.jpg" alt="app icon" class="h-5 mr-1.5">
                <h1 class="uppercase font-semibold text-3xl">Suivrepoids.fr</h1>
            </section></Link>
            <section v-if="$page.props.auth.user" class="flex flex-col items-center w-full px-4">
                <Link v-if="calculPage === 'bmi'" :href="route('calcul.bfp')" method="get" class="w-full"><button class="font-roboto font-semibold px-3 text-base h-14 mb-4 w-full border border-gray-700">IMG</button></Link>
                <Link v-if="calculPage === 'bfp'" :href="route('calcul.bmi')" method="get" class="w-full"><button class="font-roboto font-semibold px-3 text-base h-14 mb-4 w-full border border-gray-700">IMC</button></Link>
                <Link v-if="calculPage !== null" :href="route('dashboard')" method="get" class="w-full"><button class="btn-primary py-1.5 px-3 text-sm h-14 mb-4 w-full">Tableau de bord</button></Link>
                <Link :href="route('logout')" method="post" class="w-full"><button class="btn-primary py-1.5 px-3 text-sm h-14 mb-4 w-full">Se deconnecter</button></Link>
                <Link :href="route('profile.edit')" class="w-full"><button class="flex justify-center items-center bg-primary w-full h-14 transition-opacity hover:transition-opacity hover:opacity-80"><i class="fa-solid fa-user text-white text-[16px]" ></i></button></Link>
            </section>
            <section v-else class="flex flex-col items-center w-full px-4">
                <Link :href="route('login')" class="w-full"><button class="btn-primary bg-white text-black py-1.5 px-3 text-sm h-14 w-full mb-4 border border-gray-700">Se connecter</button></Link>
                <Link :href="route('register')" class="w-full"><button class="btn-primary py-1.5 px-3 text-sm h-14 w-full">Créer un compte</button></Link>
            </section>
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { onMounted, ref } from 'vue';

    const toggleMobileMenu = ref(false);
    const calculPage = ref(null);
    const windowsWidth = ref(window.innerWidth);

    onMounted(() => {
        const currentUrl = window.location.pathname;
        
        if (currentUrl === '/bmi' || currentUrl === "/bfp") {
            calculPage.value = currentUrl.slice(1);
        } else if (currentUrl === '/goals') {
            calculPage.value = currentUrl.slice(1);
        }
    });
</script>