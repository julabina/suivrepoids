<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="relative bg-gray-100 pt-5">
        <Link :href="route('home')" class="absolute text-lg left-4 transition-colors hover:transition-colors hover:text-blue-800"><p>{{ '< retour' }}</p></Link>
        <Link :href="route('register')" class="absolute text-lg text-blue-800 underline right-4 transition-colors hover:transition-colors hover:text-blue-900"><p>Créer un compte</p></Link>
        <h1 class="text-center text-3xl font-semibold mt-10 md:mt-0">Se connecter</h1>
    </div>
    <GuestLayout>
        <Head title="Se connecter" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>


        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Mot de passe" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            
            <!-- <div class="block mt-3">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div> -->
            
            <div class="flex flex-col mt-2">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-blue-800 text-sm pl-0.5 underline text-s hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                    Mot de passe oublié ?
                </Link>
            </div>

            <div class="flex items-center justify-center mt-7">
                <PrimaryButton class="w-40" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Se connecter
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
