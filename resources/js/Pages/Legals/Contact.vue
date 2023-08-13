<template>
    <Head title="contact" />

    <AuthenticatedLayout>
        <template #header/>

        <h1 class="title pt-28 text-3xl text-center">Contactez nous</h1>       
        
        <form @submit.prevent="validate" class="lg:w-[810px] bg-white px-10 pt-14 pb-8 tracking-wide mx-[4%] lg:mx-auto rounded-sm shadow-xl mt-20 font-medium">
            <div class="flex flex-col lg:flex-row w-full justify-between mb-5">
                <div class="flex flex-col lg:w-[350px] mb-5 lg:mb-0">
                    <label for="sendContactMsgFormEmail" class="mb-1 5">Votre email</label>
                    <input v-model="form.email" type="text" id="sendContactMsgFormEmail" class="input text-gray-900">
                    <span v-for="(error, ind) in v$.email.$errors" :key="'errorContactEmail' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
                <div class="flex flex-col lg:w-[350px]">
                    <label for="sendContactMsgFormName" class="mb-1 5">Votre nom</label>
                    <input v-model="form.name" type="text" id="sendContactMsgFormName" class="input text-gray-900">
                    <span v-for="(error, ind) in v$.name.$errors" :key="'errorContactname' + ind" class="text-error pl-0.5">
                        {{ error.$message }}
                    </span>
                </div>
            </div>
            <div class="flex flex-col w-full mb-5">
                <label for="sendContactMsgFormTopic" class="mb-1 5">Le sujet de votre message</label>
                <input v-model="form.topic" type="text" id="sendContactMsgFormTopic" class="input text-gray-900">
                <span v-for="(error, ind) in v$.topic.$errors" :key="'errorContacttopic' + ind" class="text-error pl-0.5">
                    {{ error.$message }}
                </span>
            </div>
            <div class="flex flex-col w-full mb-5">
                <label for="sendContactMsgFormMsg" class="mb-1 5">Votre message</label>
                <textarea v-model="form.message" id="sendContactMsgFormMsg" class="input resize-y min-h-[150px] text-gray-900"></textarea>
                <span v-for="(error, ind) in v$.message.$errors" :key="'errorContactmessage' + ind" class="text-error pl-0.5">
                    {{ error.$message }}
                </span>
            </div>
            <div class="flex justify-center mt-10">
                <button type="submit" class="btn-primary px-3 py-5 md:py-2 w-full md:w-auto">Envoyer</button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import { useVuelidate } from '@vuelidate/core'
    import { required, email } from '../../utils/i18n-validators';
    import { computed } from 'vue';

    const form = useForm({
        name: "",
        email: "",
        topic: "",
        message: "",
    });

    const rules = computed(() => {
        return {
            name: { required },
            email: { required, email },
            topic: { required },
            message: { required },
        }
    });
    const v$ = useVuelidate(rules, form);

    const validate = async () => {
        const result = await v$.value.$validate();
        console.log('re');

        if (result) {
            form.post(route('legals.sendMessage'));
        }
    };
</script>