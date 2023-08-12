<template>
    <Head title="Objectifs" />

    <AuthenticatedLayout>
        <template #header/>

        <div class="pt-28">
            <section class="flex flex-col items-center justify-between py-7 px-9 bg-white rounded-sm shadow-xl w-[600px] mb-12 mx-auto">
                <h2 class="subtitle">Mon objectif actuel</h2>
                <p class="flex justify-center items-center border border-black border-opacity-50 w-full h-14 mt-12 mb-4">
                    {{ 
                        goals[0].weight_goal !== null ?
                        'Atteindre ' + goals[0].weight_goal + ' kg'
                        : goals[0].bmi_goal !== null ?
                        'Atteindre un IMC de ' + goals[0].bmi_goal
                        :
                        'Atteindre un IMG de  ' + goals[0].bfp_goal + '%'
                    }}
                </p>
            </section>
            
            <section class="flex flex-col items-center justify-between py-7 px-9 bg-white rounded-sm shadow-xl w-[600px] mb-12 mx-auto">
                <h2 class="subtitle mb-12">Changer d'objectif</h2>
                
                <div class="flex flex-col w-full">
                    <div class="flex w-full">
                        <div class="w-1/3 border border-black border-opacity-50 h-14">
                            <div @click="goalTab = 'weight'" :class="goalTab === 'weight' ? 'flex justify-center items-center w-full h-full cursor-pointer font-medium transition-opacity hover:transition-opacity hover:opacity-70 bg-primary text-white' : 'flex justify-center items-center w-full h-full cursor-pointer transition-opacity hover:transition-opacity hover:opacity-70'">
                                <p class="uppercase text-lg">Poids</p>
                            </div>
                        </div>
                        <div class="w-1/3 border-r border-y border-black border-opacity-50 h-14">
                            <div @click="goalTab = 'bmi'" :class="goalTab === 'bmi' ? 'flex justify-center items-center w-full h-full cursor-pointer font-medium transition-opacity hover:transition-opacity hover:opacity-70 bg-primary text-white' : 'flex justify-center items-center w-full h-full cursor-pointer transition-opacity hover:transition-opacity hover:opacity-70'">
                                <p class="uppercase text-lg">Imc</p>
                            </div>
                        </div>
                        <div class="w-1/3 border-r border-y border-black border-opacity-50 h-14">
                            <div @click="goalTab = 'bfp'" :class="goalTab === 'bfp' ? 'flex justify-center items-center w-full h-full cursor-pointer font-medium transition-opacity hover:transition-opacity hover:opacity-70 bg-primary text-white' : 'flex justify-center items-center w-full h-full cursor-pointer transition-opacity hover:transition-opacity hover:opacity-70'">
                                <p class="uppercase text-lg">Img</p>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="handleGoals" class="flex flex-col items-center border-x border-b border-black border-opacity-50 w-full p-7">
                        <h3 class="font-semibold mt-3">Entrer {{ goalTab === 'weight' ? 'le poids' : goalTab === 'bmi' ? 'l\'imc' : 'l\'img' }} que vous souhaitez atteindre</h3>
                        <input v-model="goalWeight" v-if="goalTab === 'weight'" type="number" required :placeholder="'Votre poids actuel: ' + lastInfo.weight + ' kg'" min="30" max="260" class="input h-10 mt-7 [appearance:textfield] text-center w-56">
                        <input v-model="goalBmi" v-else-if="goalTab === 'bmi'" type="number" required :placeholder="'Votre IMC actuel: ' + lastInfo.bmi" min="1" max="60" class="input h-10 mt-7 [appearance:textfield] text-center w-56">
                        <input v-model="goalBfp" v-else type="number" required :placeholder="'Votre IMG actuel: ' + lastInfo.bfp + '%'" min="1" max="99" class="input h-10 mt-7 [appearance:textfield] text-center w-56">
                        <button type="submit" class="btn-primary px-5 mt-9">Valider</button>    
                    </form>
                </div>
            </section>        
            
            <section class="flex flex-col items-center justify-between py-7 px-9 bg-white rounded-sm shadow-xl w-[600px] mb-12 mx-auto">
                <h2 class="subtitle mb-6">Mes anciens objectifs</h2>
                <Goal v-for="(goal, ind) in goals" :key="'goalCard' + ind" :goal="goal" />
            </section>        
        </div>
        
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import { reactive, computed, ref, onMounted } from 'vue';
    import Goal from '@/Components/Goal.vue';

    const props = defineProps({
        goals: Array,
        lastInfo: Object,
    });

    const goalTab = ref('weight');
    const goalWeight = ref('');
    const goalBmi = ref('');
    const goalBfp = ref('');

    const handleGoals = () => {
        let goalValue = null;

        if (goalTab.value === 'weight') {
            goalValue = goalWeight.value;
        } else if (goalTab.value === 'bmi') {
            goalValue = goalBmi.value;    
        } else if (goalTab.value === 'bfp') {
            goalValue = goalBfp.value;
        }

        if (goalValue !== null && goalValue !== "") { 
            router.visit(route('goal.store'), {
                method: 'post',
                data: {
                    goalType: goalTab.value,
                    value: goalValue,
                }
            })
        }
    };
</script>