<template>
    <Head title="Indice de masse corporelle" />

    <AuthenticatedLayout>
        <template #header/>

        <h1 class="pt-24 mb-20 text-center text-primary font-black text-3xl font-fredoka">Calculer votre indice de masse corporel (IMC)</h1>

        <section v-if="$page.props.auth.user" class="w-[600px] bg-white py-7 mx-auto text-center rounded-sm shadow-xl mb-12">
            <p class="font-medium mb-1.5">Votre IMC est de</p>
            <span class="font-semibold text-3xl">{{ props.bmi }}</span>
            <p class="mt-14 mb-1 font-medium">Avec votre IMC, vous etes (selon l'OMS) en</p>
            <span class="font-semibold text-lg">{{ userBmiStatus }}</span>
            <p class="font-medium mt-14">Selon votre taille votre poids idéal se situe entre {{ weightMin }}kg et {{ weightMax }}kg.</p>
        </section>

        <section  class="w-[600px] bg-white p-7 tracking-wide mx-auto rounded-sm shadow-xl mb-12 font-medium">
            <p class="mb-4">L'indice de masse corporelle permet de rapidement évaluer votre corpulence avec votre poids et votre taille indépendamment de votre sexe.</p>
            <p class="mb-4">Il se calcul simplement en divisant le poids par le carré de la taille (en metre).Un IMC normal (selon l'OMS) se situe entre 18,5 et 25.</p>
            <p class="mb-4">Pour connaitre le votre, rien de plus simple, il vous suffit de remplir les champs ci dessous.</p>
            <form @submit.prevent="submit" class="my-12 flex flex-col">
                <div class="flex justify-center">
                    <div class="flex flex-col mx-4">
                        <label for="bmiFormSize" class="mb-1.5 font-normal text-sm">Taille en cm</label>
                        <input v-model="form.size" type="number" id="bmiFormSize" min="90" max="260" placeholder="175" class="w-40 h-9 [appearance:textfield] pl-5">
                        <span v-for="(error, ind) in v$.size.$errors" :key="'errorBmiSize' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                    </div>
                    <div class="flex flex-col mx-4">
                        <label for="bmiFormWeight" class="mb-1.5 font-normal text-sm">Poids en kg</label>
                        <input v-model="form.weight" type="number" id="bmiFormWeight" min="30" max="260" placeholder="80" class="w-40 h-9 [appearance:textfield] pl-5">
                        <span v-for="(error, ind) in v$.weight.$errors" :key="'errorBmiWeight' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                    </div>
                </div>
                <div class="flex justify-center mt-9">
                    <button class="btn-primary px-4">Calculer</button>
                </div>
            </form>

            <p v-if="bmiResult !== null" class="text-center font-semibold text-4xl text-primary">{{ bmiResult }}</p>

            <h2 class="text-center font-extrabold text-xl mt-12 mb-6">Interprétation de l'IMC (selon l'OMS)</h2>

            <div class="flex flex-col">
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-1/2 text-right pr-4 font-semibold text-lg">En dessous de 16,5</p>
                    <p class="w-1/2 pl-4 font-normal">Maigreur extreme</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-1/2 text-right pr-4 font-semibold text-lg">Entre 16,5 et 18.4</p>
                    <p class="w-1/2 pl-4 font-normal">Maigreur</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-1/2 text-right pr-4 font-semibold text-lg">Entre 18.5 et 24.9</p>
                    <p class="w-1/2 pl-4 font-normal">Corpulence normal</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-1/2 text-right pr-4 font-semibold text-lg">Entre 25 et 29.9</p>
                    <p class="w-1/2 pl-4 font-normal">Surpoids</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-1/2 text-right pr-4 font-semibold text-lg">Entre 30 et 34.9</p>
                    <p class="w-1/2 pl-4 font-normal">Obésité modérée</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-1/2 text-right pr-4 font-semibold text-lg">Entre 35 et 39.9</p>
                    <p class="w-1/2 pl-4 font-normal">Obésité sévère</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-1/2 text-right pr-4 font-semibold text-lg">Au dessus de 40</p>
                    <p class="w-1/2 pl-4 font-normal">Obésité morbide</p>
                </div>
            </div>
        </section>
        
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { reactive, computed, ref, onMounted } from 'vue';
    import { useVuelidate } from '@vuelidate/core'
    import { required } from '../utils/i18n-validators';

    const props = defineProps({
        bmi: Number|null,
        weightMin: Number|null,
        weightMax: Number|null,
    });

    const form = reactive({
        size: 0,
        weight: 0,
    });

    const bmiResult = ref(null);
    const userBmiStatus = ref('');

    onMounted(() => {
        form.size = "";
        form.weight = "";

        if (props.bmi !== null) {
            if(props.bmi < 16.5) {
                userBmiStatus.value = "Maigreur extreme";
            } else if(props.bmi >= 16.5 && props.bmi < 18.5) {
                userBmiStatus.value = "Maigreur";
            } else if(props.bmi >= 18.5 && props.bmi < 25) {
                userBmiStatus.value = "Corpulence normale";
            } else if(props.bmi >= 25 && props.bmi < 30) {
                userBmiStatus.value = "Surpoids";
            } else if(props.bmi >= 30 && props.bmi < 35) {
                userBmiStatus.value = "Obésité modérée";
            } else if(props.bmi >= 35 && props.bmi < 40) {
                userBmiStatus.value = "Obésité sévère";
            } else if(props.bmi >= 40) {
                userBmiStatus.value = "Obésité morbide";
            }
        }
    });

    const rules = computed(() => {
        return {
            size: { required },
            weight: { required },
        }
    });
    const v$ = useVuelidate(rules, form);

    const submit = async () => {
        const result = await v$.value.$validate();

        if (result) {   
            const formatSize = form.size / 100;
            const bmi = form.weight / (formatSize*formatSize);

            return bmiResult.value = Math.floor(bmi*10)/10; 
        }
    };
</script>