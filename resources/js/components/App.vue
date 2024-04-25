<template>
  <div>
    <p>{{ counter }}</p>
    <button @click="counter += 1">Click!</button>

    <div class="q-pa-md q-gutter-sm">
      <q-btn push color="white" text-color="primary" label="Unread Mails">
        <q-badge color="orange" floating>22</q-badge>
      </q-btn>

      <q-btn dense color="purple" round icon="email" class="q-ml-md">
        <q-badge color="red" floating>4</q-badge>
      </q-btn>
    </div>
  </div>
</template>

<script setup>
  const counter = defineModel({ default: 0 });
</script>