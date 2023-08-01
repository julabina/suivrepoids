<template>
    <Head title="Objectifs" />

    <AuthenticatedLayout>
        <template #header/>

       
        
    </AuthenticatedLayout>
</template>
    
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { reactive, computed, ref, onMounted } from 'vue';
    import { useVuelidate } from '@vuelidate/core'
    import { required } from '../utils/i18n-validators';

 
</script>