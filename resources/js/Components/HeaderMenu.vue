<template>
    <div class="flex justify-between max-w-7xl mx-auto h-full px-8">
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
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { onMounted, ref } from 'vue';

    const calculPage = ref(null);

    onMounted(() => {
        const currentUrl = window.location.pathname;
        
        if (currentUrl === '/bmi' || currentUrl === "/bfp") {
            calculPage.value = currentUrl.slice(1);
        } else if (currentUrl === '/goals') {
            calculPage.value = currentUrl.slice(1);
        }
    });
</script>