<template>
    <Head title="Tableau de bord" />

    <AuthenticatedLayout>
        <template #header/>

        <h1 class="pt-24 text-center title uppercase text-3xl mb-14">Tableau de bord</h1>
        
        <section class="flex mx-auto w-[810px] mb-8">
            <div @click="toggleModal = true" class="flex flex-col items-center justify-center bg-white rounded-sm shadow-xl w-1/3 h-36 mr-4 hover:border cursor-pointer">
                <h2 class="font-medium">Votre poids au </h2>
            </div>
            <Link :href="route('calcul.bmi')" class="bg-white rounded-sm shadow-xl w-1/3 h-36 mx-2 hover:border cursor-pointer"><div class="flex flex-col items-center justify-center h-full">
                <h2 class="font-medium">Votre IMC</h2>
            </div></Link>
            <Link :href="route('calcul.bfp')" class="bg-white rounded-sm shadow-xl w-1/3 h-36 ml-4 hover:border cursor-pointer"><div class="flex flex-col items-center justify-center h-full">
                <h2 class="font-medium">Votre IMG</h2>
            </div></Link>
        </section>

        <section class="flex flex-col items-center py-6 bg-white rounded-sm shadow-xl w-[810px] mb-8 h-40 mx-auto hover:border cursor-pointer">
            <h2 class="font-medium">Votre objectif actuel</h2>
        </section>

        <section class="mx-auto w-[810px] mb-8">
            <div class="flex">
                <div @click="tab = 'chart'" :class="tab === 'chart' ? 'flex justify-center items-center cursor-pointer w-40 h-12 bg-white rounded-sm' : 'flex justify-center items-center cursor-pointer w-40 h-12 bg-gray-300 rounded-sm'">
                    <p>Graphique</p>
                </div>
                <div @click="tab = 'list'" :class="tab === 'list' ? 'flex justify-center items-center cursor-pointer w-40 h-12 bg-white rounded-sm' : 'flex justify-center items-center cursor-pointer w-40 h-12 bg-gray-300 rounded-sm'">
                    <p>Liste</p>
                </div>
            </div>
            <div class="bg-white rounded-sm shadow-xl p-8 h-full">

            </div>
        </section>

        <div v-if="toggleModal === true" class="fixed top-0 bottom-0 left-0 right-0 bg-black bg-opacity-75 z-50">
            <div class="absolute flex flex-col items-center left-1/2 top-1/3 -translate-x-1/2 -translate-y-1/3 p-6 bg-white rounded-xs">
                <i @click="toggleModal = false" class="fa-solid fa-xmark absolute top-4 right-5 cursor-pointer transition-opacity hover:transition-opacity hover:opacity-60"></i>
                <h2 class="subtitle mt-5">Ajouter un nouveau poids</h2>
                <input type="number" class="mt-6 mb-10 w-56 input h-9 [appearance:textfield]" min="30" max="260">
                <button class="btn-primary py-2 px-3">Ajouter</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const tab = ref('chart');
    const toggleModal = ref(false);
</script>
