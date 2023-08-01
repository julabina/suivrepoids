<template>
    <Head title="indice de masse graisseuse" />

    <AuthenticatedLayout>
        <template #header/>

        <h1 class="pt-24 mb-20 text-center text-primary font-black text-3xl font-fredoka">Calculer votre indice de masse graisseuse (IMG)</h1>

        <section v-if="$page.props.auth.user" class="w-[600px] bg-white py-7 mx-auto text-center rounded-sm shadow-xl mb-12">
            <p class="font-medium mb-1.5">Votre IMG est de</p>
            <span class="font-semibold text-3xl">{{ props.bfp }}%</span>
            <p class="mt-14 mb-1 font-medium">Avec votre IMG, vous etes (selon Deurenberg)</p>
            <span class="font-semibold text-lg">{{ userBfpStatus }}</span>
        </section>

        <section  class="w-[600px] bg-white p-7 tracking-wide mx-auto rounded-sm shadow-xl mb-12 font-medium">
            <p class="mb-4">L'indice de masse grasse permet de définir la proportion de graisse dans le corps.</p>
            <p class="mb-4">Il se calcul en fonction du sexe et de l'age de l'individu, grace à la formule de Deurenberg.</p>
            <ul class="flex flex-col mb-4">
                <li class="list-disc ml-6 mb-1.5 text-sm"><p>Chez l' homme : <span class="font-light">IMG (en %) = (1.20 x IMC) + (0.23 x Age) - (10.8 x 1) - 5.4</span></p></li>
                <li class="list-disc ml-6 text-sm"><p>Chez la femme : <span class="font-light">IMG (en %) = (1.20 x IMC) + (0.23 x Age) - (10.8 x 0) - 5.4</span></p></li>
            </ul>
            <p class="mb-4">Pour connaitre le votre, rien de plus simple, il vous suffit de remplir les champs ci dessous.</p>
            <form @submit.prevent="submit" class="my-12 flex flex-col">
                <div class="flex justify-center mb-4">
                    <div class="flex flex-col mx-4">
                        <label for="bfpFormSize" class="mb-1.5 font-normal text-sm">Taille en cm</label>
                        <input v-model="form.size" type="number" id="bfpFormSize" min="90" max="260" placeholder="175" class="w-40 h-9 [appearance:textfield] pl-5">
                        <span v-for="(error, ind) in v$.size.$errors" :key="'errorBfpSize' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                    </div>
                    <div class="flex flex-col mx-4">
                        <label for="bfpFormWeight" class="mb-1.5 font-normal text-sm">Poids en kg</label>
                        <input v-model="form.weight" type="number" id="bfpFormWeight" min="30" max="260" placeholder="80" class="w-40 h-9 [appearance:textfield] pl-5">
                        <span v-for="(error, ind) in v$.weight.$errors" :key="'errorBfpWeight' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="flex flex-col mx-4">
                        <label for="bfpFormAge" class="mb-1.5 font-normal text-sm">Age</label>
                        <input v-model="form.age" type="number" id="bfpFormAge" min="12" max="99" placeholder="30" class="w-40 h-9 [appearance:textfield] pl-5">
                        <span v-for="(error, ind) in v$.age.$errors" :key="'errorBfpSize' + ind" class="text-error pl-0.5">
                            {{ error.$message }}
                        </span>
                    </div>
                    <div class="flex flex-col mx-4">
                        <label for="bfpFormSexe" class="mb-1.5 font-normal text-sm">Sexe</label>
                        <select v-model="form.sexe" id="registerSexe" class="w-40 h-9">
                            <option value="man">Homme</option>
                            <option value="woman">Femme</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center mt-9">
                    <button class="btn-primary px-4">Calculer</button>
                </div>
            </form>

            <p v-if="bfpResult !== null" class="text-center font-semibold text-4xl text-primary">{{ bfpResult }}%</p>

            <h2 class="text-center font-extrabold text-xl mt-12 mb-6">Interprétation de l'IMG</h2>
            <p class="mb-3 font-normal">Vous trouverez ci-dessous un tableau qui indique l'indice de masse graisseuse idéal suivant votre age et votre sexe.</p>
            <p class="mb-7 font-normal">Si votre résultat est en dessous vous etes trop maigre, et au contraire s'il est au dessus vous avez un excedent de graisse.</p>

            <h3 class="text-center font-semibold mb-3">Si vous etes un homme</h3>
            <div class="flex flex-col">
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">Entre 18 et 24 ans, votre IMG idéal est compris entre 8% et 17%</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-full text-center font-normal">Entre 25 et 29 ans, votre IMG idéal est compris entre 11% et 18%</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">Entre 30 et 39 ans, votre IMG idéal est compris entre 12% et 19%</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-full text-center font-normal">Entre 40 et 44 ans, votre IMG idéal est compris entre 13% et 21%</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">Entre 45 et 49 ans, votre IMG idéal est compris entre 15% et 22%</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-full text-center font-normal">Entre 50 et 59 ans, votre IMG idéal est compris entre 17% et 24%</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">A partir de 60 ans, votre IMG idéal est compris entre 19% et 26%</p>
                </div>
            </div>
            
            <h3 class="text-center font-semibold mt-4 mb-3">Si vous etes une femme</h3>
            <div class="flex flex-col">
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">Entre 18 et 24 ans, votre IMG idéal est compris entre 22% et 29%</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-full text-center font-normal">Entre 25 et 29 ans, votre IMG idéal est compris entre 23% et 30%</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">Entre 30 et 39 ans, votre IMG idéal est compris entre 24% et 31%</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-full text-center font-normal">Entre 40 et 44 ans, votre IMG idéal est compris entre 25% et 33%</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">Entre 45 et 49 ans, votre IMG idéal est compris entre 27% et 34%</p>
                </div>
                <div class="flex items-center bg-primary text-white w-full h-10">
                    <p class="w-full text-center font-normal">Entre 50 et 59 ans, votre IMG idéal est compris entre 29% et 36%</p>
                </div>
                <div class="flex items-center bg-gray-200 w-full h-10">
                    <p class="w-full text-center font-normal">A partir de 60 ans, votre IMG idéal est compris entre 31% et 38%</p>
                </div>
            </div>

            <p class="mt-6 text-xs font-light text-center">Ces valeurs sont à titre indicatif, et ne remplace pas l'avis d'un medecin.</p>
        </section>
        
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { reactive, computed, ref, onMounted } from 'vue';
    import { useVuelidate } from '@vuelidate/core'
    import { required } from '../utils/i18n-validators';

    const props = defineProps({
        bmi: Number|null,
        bfp: Number|null,
    });

    const form = reactive({
        size: 0,
        weight: 0,
        age: 0,
        sexe: 'man',
    });

    const bfpResult = ref(null);
    const userBfpStatus = ref('');

    onMounted(() => {
        form.size = "";
        form.weight = "";
        form.age = "";

        if (props.bmi !== null) {

            const user = usePage().props.auth.user;

            const age = calculAge(user.birthday);

            if(user.is_man === false) {
                if(age < 25) {
                    if(props.bmi < 22) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 29) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 30 && age >= 25) {
                    if(props.bmi < 23) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 30) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 40 && age >= 30) {
                    if(props.bmi < 24) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 31) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 45 && age >= 40) {
                    if(props.bmi < 25) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 33) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 50 && age >= 45) {
                    if(props.bmi < 27) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 34) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 60 && age >= 50) {
                    if(props.bmi < 29) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 36) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age >= 60) {
                    if(props.bmi < 31) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 38) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                }
            } else {
                if(age < 25) {
                    if(props.bmi < 8) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 17) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 30 && age >= 25) {
                    if(props.bmi < 11) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 18) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 40 && age >= 30) {
                    if(props.bmi < 12) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 19) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 45 && age >= 40) {
                    if(props.bmi < 13) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 21) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 50 && age >= 45) {
                    if(props.bmi < 15) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 22) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age < 60 && age >= 50) {
                    if(props.bmi < 17) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 24) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                } else if(age >= 60) {
                    if(props.bmi < 19) {
                        userBfpStatus.value = "Trop maigre";
                    } else if(props.bmi > 26) {
                        userBfpStatus.value = "En excedent de graisse";
                    } else {
                        userBfpStatus.value = "Normal";
                    }
                }
            }
        }
    });

    const rules = computed(() => {
        return {
            size: { required },
            weight: { required },
            age: { required },
        }
    });
    const v$ = useVuelidate(rules, form);

    const submit = async () => {
        const result = await v$.value.$validate();

        if (result) {   
            const formatSize = form.size / 100;
            const bmi = Math.floor(form.weight / (formatSize*formatSize));
            let bfp;

            if(form.sexe === "man") {
                bfp = (1.2*bmi)+(0.23*form.age)-(10.8*1)-5.4;
            } else if(form.sexe === "woman") {
                bfp = (1.2*bmi)+(0.23*form.age)-(10.8*0)-5.4;
            }

            bfpResult.value = Math.floor(bfp*10)/10;
        }
    };

    const calculAge = (birthday) => {
        return Math.abs(new Date(Date.now() - (birthday ? new Date(birthday) : new Date()).getTime()).getUTCFullYear() - 1970);
    };
</script>