<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <div class="relative bg-gray-100 pt-5">
        <Link :href="route('login')" class="absolute text-lg left-4 transition-colors hover:transition-colors hover:text-blue-800"><p>{{ '< retour' }}</p></Link>
        <h1 class="text-center text-3xl font-semibold">Récupérer votre mot de passe</h1>
    </div>
    <GuestLayout>
        <Head title="Mot de passe oublié" />

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

            <div class="flex items-center justify-center mt-10">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    <span class="px-4">Envoyer</span>
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
