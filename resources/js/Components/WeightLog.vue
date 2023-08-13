<template>
    <li class="py-3 md:py-1.5 flex justify-between border-b border-gray-400 mb-1">
        <p class="w-2/6 md:w-1/5 text-center">{{ recordDate !== null && recordDate.toLocaleDateString('FR') }}</p>
        <p class="w-1/6 md:w-1/5 text-center">{{ log.weight }}</p>
        <p class="w-1/6 md:w-1/5 text-center">{{ log.bmi }}</p>
        <p class="w-1/6 md:w-1/5 text-center">{{ log.bfp }}</p>
        <div class="flex justify-center w-1/6 md:w-1/5">
            <Link v-if="index !== 0" :href="route('weight.delete', { id: log.id })" method="delete" class="btn-primary px-1.5 py-0.5">X</Link>
        </div>
    </li>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

    const props = defineProps({
        log: Object,
        index: Number,
    });

    const recordDate = ref(null);

    onMounted(() => {
        recordDate.value = new Date(props.log.record_date);
    });
</script>