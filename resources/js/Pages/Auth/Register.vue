<script setup>
import RegisterLayout from '@/Layouts/RegisterLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="relative bg-gray-100 pt-5">
        <Link :href="route('home')" class="absolute text-lg left-4 transition-colors hover:transition-colors hover:text-blue-800"><p>{{ '< retour' }}</p></Link>
        <Link :href="route('login')" class="absolute text-lg text-blue-800 underline right-4 transition-colors hover:transition-colors hover:text-blue-900"><p>Se connecter</p></Link>
        <h1 class="text-center text-3xl font-semibold">S'enregistrer</h1>
    </div>
    <RegisterLayout>
        <Head title="Inscription" />

        <form @submit.prevent="submit" class="">
            <section class="flex flex-row-reverse">
                <div class="w-64">
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
    
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
    
                <div class="w-64 mr-6">
                    <InputLabel for="email" value="Email" />
    
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
    
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </section>
            <section class="flex mt-4">

                <div class="w-64 mr-6">
                    <InputLabel for="password" value="Mot de passe" />
                    
                    <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    />
                    
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                
                <div class="w-64">
                    <InputLabel for="password_confirmation" value="Confirmer mot de passe" />
                    
                    <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    />
                    
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </section>

            <section class="flex mt-4">
                <div class="w-64 mr-6">
                    <InputLabel for="registerSize" value="Taille en cm" />
                    <input type="number" id="registerSize" class="input [appearance:textfield]">
                </div>

                <div class="w-64">
                    <InputLabel for="registerWeight" value="Votre poids actuel" />
                    <input type="number" id="registerWeight" class="input [appearance:textfield]">
                </div>
            </section>
            
            <section class="flex mt-4">
                <div class="mr-6">
                    <InputLabel for="registerSexe" value="Sexe" />
                    <select id="registerSexe" class="input">
                        <option value="">Homme</option>
                        <option value="">Femme</option>
                    </select>
                </div>
                
                <div>
                    <InputLabel for="registerBirthday" value="Date de naissance" />
                    <input type="date" id="registerBirthday" class="input">
                </div>
            </section>
            
            <section class="flex items-center mt-4">
                <input type="checkbox" id="registerCGU" class="h-5 w-5 border-2 border-gray-400 rounded-sm">
                <label class="ml-2" for="registerCGU">J'ai lu et j'accepte les <Link href="" class="text-blue-800 underline">Conditions Générales d'Utilisation</Link>.</label>
            </section>

            <section class="flex justify-center">
                <PrimaryButton class="w-44 mt-8" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Créer un compte
                </PrimaryButton>

            </section>
        </form>
    </RegisterLayout>
</template>
