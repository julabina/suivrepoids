<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header/>
        

        <div class="flex justify-center pt-24">
            <div class="w-[810px] mx-auto sm:px-6 lg:px-8 space-y-6">
                <Link :href="route('dashboard')" class="cgu-link pl-1.5">Retour au tableau de bord</Link>
                <div class="flex justify-center p-4 sm:p-8 bg-white shadow-xl sm:rounded-sm">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="flex justify-center p-4 sm:p-8 bg-white shadow-xl sm:rounded-sm">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <!-- <div class="flex justify-center p-4 sm:p-8 bg-white shadow-xl sm:rounded-sm">
                    <DeleteUserForm class="max-w-xl" />
                </div> -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
