<script setup>
    import RegisterLayout from '@/Layouts/RegisterLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { useVuelidate } from '@vuelidate/core'
    import { required, email } from '../../utils/i18n-validators';
    import { computed, ref, watch } from 'vue';

    const props = defineProps({
        emailError: Boolean,
    });

    watch(() => props.emailError, (newVal, prevVal) => {
        errorEmail.value = props.emailError;
    });

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        size: null,
        weight: null,
        sexe: 'man',
        birthday: '',
    });

    const errorCGU = ref(false);
    const errorConfirm = ref(false);
    const errorEmail = ref(false);
    const validateCGU = ref(false);

    const rules = computed(() => {
        return {
            name: { required },
            email: { required, email },
            password: { required },
            password_confirmation: { required },
            size: { required },
            weight: { required },
            sexe: { required },
            birthday: { required },
        }
    });
    const v$ = useVuelidate(rules, form);

    const submit = async () => {
        const result = await v$.value.$validate();
        errorCGU.value = false;
        errorConfirm.value = false;

        if (form.password !== form.password_confirmation) {
            return errorConfirm.value = true;
        }
        
        if (validateCGU.value === false) {
            return errorCGU.value = true;
        }

        if (result) {   
            form.post(route('register'), {
                onFinish: () => form.reset('password', 'password_confirmation'),
            });
        }
    };
</script>

<template>
    <div class="relative bg-gray-100 pt-5">
        <Link :href="route('home')" class="absolute text-lg left-4 transition-colors hover:transition-colors hover:text-blue-800"><p>{{ '< retour' }}</p></Link>
        <Link :href="route('login')" class="absolute text-lg text-blue-800 underline right-4 transition-colors hover:transition-colors hover:text-blue-900"><p>Se connecter</p></Link>
        <h1 class="text-center text-3xl font-semibold mt-10 md:mt-0">S'enregistrer</h1>
    </div>
    <RegisterLayout>
        <Head title="Inscription" />

        <form @submit.prevent="submit" class="">
            <section class="flex flex-col md:flex-row-reverse">
                <div class="md:w-64">
                    <InputLabel for="name" value="Prénom/pseudo" />
    
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
    
                    <span v-for="(error, ind) in v$.name.$errors" :key="'errorName' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
    
                <div class="md:w-64 mt-4 md:mt-0 md:mr-6">
                    <InputLabel for="email" value="Email" />
    
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
    
                    <span v-for="(error, ind) in v$.email.$errors" :key="'errorEmail' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                    <span v-if="errorEmail === true" class="text-error pl-0.5">
                        L'email est deja utilisé.
                    </span>
                </div>
            </section>
            <section class="flex flex-col md:flex-row mt-4">

                <div class="md:w-64 mb-4 md:mb-0 md:mr-6">
                    <InputLabel for="password" value="Mot de passe" />
                    
                    <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    />
                    
                    <span v-for="(error, ind) in v$.password.$errors" :key="'errorPassword' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                    <span v-if="errorConfirm === true" class="text-error pl-0.5">
                        Les mot de passe doivent etre identique.
                    </span>
                </div>
                
                <div class="md:w-64">
                    <InputLabel for="password_confirmation" value="Confirmer mot de passe" />
                    
                    <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    />
                    
                    <span v-for="(error, ind) in v$.password_confirmation.$errors" :key="'errorPasswordConfirmation' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
            </section>

            <section class="flex flex-col md:flex-row mt-4">
                <div class="md:w-64 mb-4 md:mb-0 md:mr-6">
                    <InputLabel for="registerSize" value="Taille en cm" />
                    <input v-model="form.size" required min="90" max="260" type="number" id="registerSize" class="input w-full [appearance:textfield]">
                    <span v-for="(error, ind) in v$.size.$errors" :key="'errorSize' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>

                <div class="md:w-64">
                    <InputLabel for="registerWeight" value="Votre poids actuel" />
                    <input v-model="form.weight" required min="30" max="260" type="number" id="registerWeight" class="input w-full [appearance:textfield]">
                    <span v-for="(error, ind) in v$.weight.$errors" :key="'errorWeight' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
            </section>
            
            <section class="flex mt-4">
                <div class="flex flex-col mr-6">
                    <InputLabel for="registerSexe" value="Sexe" />
                    <select v-model="form.sexe" id="registerSexe" class="input">
                        <option value="man">Homme</option>
                        <option value="woman">Femme</option>
                    </select>
                    <span v-for="(error, ind) in v$.sexe.$errors" :key="'errorSexe' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
                
                <div class="flex flex-col">
                    <InputLabel for="registerBirthday" value="Date de naissance" />
                    <input v-model="form.birthday" required type="date" id="registerBirthday" class="input">
                    <span v-for="(error, ind) in v$.birthday.$errors" :key="'errorBirthday' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
            </section>
            
            <section class="flex flex-col mt-8 md:mt-4">
                <div class="flex items-center">
                    <input v-model="validateCGU" type="checkbox" id="registerCGU" class="h-7 w-7 md:h-5 md:w-5 border-2 border-gray-400 rounded-sm">
                    <label class="ml-2" for="registerCGU">J'ai lu et j'accepte les <Link :href="route('legals.cgu')" class="text-blue-800 underline">Conditions Générales d'Utilisation</Link>.</label>
                </div>
                <span v-if="errorCGU === true" class="text-error pl-0.5">
                    Vous devez accepter les conditions générales d'utilisation.
                </span>
            </section>

            <section class="flex justify-center">
                <PrimaryButton class="w-full md:w-44 mt-12 md:mt-8" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Créer un compte
                </PrimaryButton>

            </section>
        </form>
    </RegisterLayout>
</template>
