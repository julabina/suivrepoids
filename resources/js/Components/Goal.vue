<template>
    <article class="text-center border border-black border-opacity-50 p-4 w-full mt-2.5">
        <p>Atteindre {{ goal.weight_goal !== null ? 'le poids de ' + goal.weight_goal + ' kg' : goal.bmi_goal !== null ? 'un IMC de ' + goal.bmi_goal : 'un IMG de ' + goal.bfp_goal + '%' }}</p>
        <p>Créer le {{ createdDate }}</p>
        <p v-if="successDate !== null">Objectif réaliser le {{ successDate }}</p>
    </article>
</template>

<script setup>
    import { onMounted, ref } from 'vue';

    const createdDate = ref(null);
    const successDate = ref(null);

    const props = defineProps({
        goal: Object,
    });
    
    onMounted(() => {
        createdDate.value = new Date(props.goal.created_at).toLocaleDateString('FR');
        
        if (props.goal.success === true) {
            successDate.value = new Date(props.goal.updated_at).toLocaleDateString('FR');
        }
    });
</script>