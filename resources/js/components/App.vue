<template>
    <div>
        <p>{{ counter }}</p>
        <button @click="counter += 1">Click!</button>
    </div>
</template>

<script setup>
    const counter = defineModel({ default: 0 });
</script>