<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-error">
            {{ message }}
        </p>
    </div>
</template>
