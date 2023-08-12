<template>
    <Head title="Tableau de bord" />

    <AuthenticatedLayout>
        <template #header/>

        <h1 class="pt-24 text-center title uppercase text-3xl mb-14">Tableau de bord</h1>
        
        <section class="flex mx-auto w-[810px] mb-8">
            <div @click="toggleModal = true" class="flex flex-col items-center pt-6 bg-white rounded-sm shadow-xl w-1/3 h-36 mr-4 hover:border cursor-pointer">
                <h2 class="font-medium mb-3">Votre poids au {{ recordDate }}</h2>
                <p class="font-bold text-3xl">{{ lastInfo.weight }}</p>
                <p class="font-light text-xs">Cliquer pour ajouter un nouveau poids.</p>
            </div>
            <Link :href="route('calcul.bmi')" class="bg-white rounded-sm shadow-xl w-1/3 h-36 mx-2 hover:border cursor-pointer"><div class="flex flex-col items-center pt-6 h-full">
                <h2 class="font-medium mb-3">Votre IMC</h2>
                <p class="font-bold text-3xl">{{ lastInfo.bmi }}</p>
            </div></Link>
            <Link :href="route('calcul.bfp')" class="bg-white rounded-sm shadow-xl w-1/3 h-36 ml-4 hover:border cursor-pointer"><div class="flex flex-col items-center pt-6 h-full">
                <h2 class="font-medium mb-3">Votre IMG</h2>
                <p class="font-bold text-3xl">{{ lastInfo.bfp }}%</p>
            </div></Link>
        </section>

        <Link :href="route('goal.show')"><section :class="goal.success === true ? 'flex flex-col items-center justify-between py-6 bg-green-400 rounded-sm shadow-xl w-[810px] mb-8 h-40 mx-auto hover:border cursor-pointer' : 'flex flex-col items-center justify-between py-6 bg-white rounded-sm shadow-xl w-[810px] mb-8 h-40 mx-auto hover:border cursor-pointer'">
            <div v-if="goal === null" class="flex flex-col items-center">
                <h2 class="font-medium">Vous pouvez définir un objectif ici !!</h2>
            </div>
            <div v-else class="flex flex-col items-center">
                <h2 v-if="goal.success === true" class="font-medium mb-8">Objectif Atteint, Félicitation !</h2>
                <h2 v-else class="font-medium mb-7">Votre objectif actuel</h2>
                <p v-if="goal.weight_goal !== null" class="font-semibold text-xl">Atteindre le poids de {{ goal.weight_goal }}kg</p>
                <p v-else-if="goal.bmi_goal !== null" class="font-semibold text-xl">Atteindre un IMC de {{ goal.bmi_goal }}</p>
                <p v-else-if="goal.bfp_goal !== null" class="font-semibold text-xl">Atteindre un IMG de {{ goal.bfp_goal }}%</p>
            </div>
            <p :class="goal === null ? 'pb-4 text-sm font-light' : 'text-sm font-light'">Cliquer pour définir un nouvel objectif!</p>
        </section></Link>

        <section class="mx-auto w-[810px] mb-8">
            <div class="flex">
                <div @click="tab = 'chart'" :class="tab === 'chart' ? 'flex justify-center items-center cursor-pointer w-40 h-12 bg-white rounded-sm' : 'flex justify-center items-center cursor-pointer w-40 h-12 bg-gray-300 rounded-sm'">
                    <p>Graphique</p>
                </div>
                <div @click="tab = 'list'" :class="tab === 'list' ? 'flex justify-center items-center cursor-pointer w-40 h-12 bg-white rounded-sm' : 'flex justify-center items-center cursor-pointer w-40 h-12 bg-gray-300 rounded-sm'">
                    <p>Liste</p>
                </div>
            </div>
            <div class="bg-white rounded-sm shadow-xl p-8 h-full min-h-[250px]">
                <ul v-if="tab === 'list'">
                    <li class="py-1.5 flex justify-between border-b border-gray-400 mb-1">
                        <p class="font-semibold text-center w-1/5">Date</p>
                        <p class="font-semibold text-center w-1/5">Poids</p>
                        <p class="font-semibold text-center w-1/5">IMC</p>
                        <p class="font-semibold text-center w-1/5">IMG</p>
                        <p class="w-1/5"></p>
                    </li>
                    <WeightLog v-for="(log, ind) in infos.reverse()" :key="'weightLog' + ind" :log="log" :index="ind" />
                </ul>
                <div v-else-if="tab === 'chart'" class="">
                    <GoogleChart :infos="infos" :years="years"/>
                </div>
            </div>
        </section>

       <!-- <MultiplexAds /> -->

        <!-- ADD NEW WEIGHT MODAL START -->
        <div v-if="toggleModal === true" class="fixed top-0 bottom-0 left-0 right-0 bg-black bg-opacity-75 z-50">
            <form v-if="alreadyNewWeight === false" @submit.prevent="addWeight" class="absolute flex flex-col items-center left-1/2 top-1/3 -translate-x-1/2 -translate-y-1/3 p-6 bg-white rounded-xs">
                <i @click="toggleModal = false" class="fa-solid fa-xmark absolute top-4 right-5 cursor-pointer transition-opacity hover:transition-opacity hover:opacity-60"></i>
                <h2 class="subtitle mt-5">Ajouter un nouveau poids</h2>
                <input v-model="form.weight" type="number" class="mt-6 w-56 input h-9 [appearance:textfield]" min="30" max="260">
                <span class="text-error mb-10">{{ errorWeight === true ? 'Veuillez entrer un poids' : '' }}</span>
                <button type="submit" class="btn-primary py-2 px-3">Ajouter</button>
            </form>
            <div v-else class="absolute flex flex-col items-center left-1/2 top-1/3 -translate-x-1/2 -translate-y-1/3 p-6 bg-white rounded-xs">
                <h2 class="font-semibold pt-12">Vous ne pouvez ajouter qu'un seul poids par jour</h2>
                <button @click="toggleModal = false" class="btn-primary mb-5 py-2 px-7 mt-7">Ok</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
    
<script setup>
    import GoogleChart from '@/Components/GoogleChart.vue';
    import MultiplexAds from '@/Components/MultiplexAds.vue';
    import WeightLog from '@/Components/WeightLog.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { onMounted, ref, onBeforeMount } from 'vue';

    const props = defineProps({
        infos: Array,
        lastInfo: Object,
        goal: Object,
        years: Array,
    });

    const form = useForm({
        weight: '',
    });

    const tab = ref('chart');
    const toggleModal = ref(false);
    const errorWeight = ref(false);
    const recordDate = ref(null);
    const alreadyNewWeight = ref(false);

    onBeforeMount(() => {
        recordDate.value = new Date(props.lastInfo.record_date).toLocaleDateString('FR');
    });
    
    onMounted(() => {
        const currentDate = new Date();
        const date = new Date(props.lastInfo.record_date);
        
        if (currentDate.toDateString() === date.toDateString()) {
           alreadyNewWeight.value = true;
        }
    });

    const addWeight = () => {
        errorWeight.value = false;
        
        if (form.weight === '') {
            return errorWeight.value = true;
        }

        form.post(route('weight.store'));

        form.weight = '';
        toggleModal.value = false;
    };  
</script>
