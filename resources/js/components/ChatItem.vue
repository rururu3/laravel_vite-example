<template>
  <div class="q-pa-md q-gutter-md">
    <q-list bordered class="rounded-borders" style="max-width: 350px">
      <q-item-label header>Friends</q-item-label>

      <q-item clickable v-ripple>
        <q-item-section avatar>
          <q-avatar>
            <img src="https://cdn.quasar.dev/img/avatar2.jpg">
          </q-avatar>
        </q-item-section>

        <q-item-section>
          <q-item-label lines="1">{{ chatdata.title }}</q-item-label>
          <q-item-label caption lines="2">
            <span class="text-weight-bold">{{ chatdata.name }}</span>
            {{ chatdata.message }}
          </q-item-label>
        </q-item-section>

        <q-item-section side top>
          {{ chatdata.date }}
        </q-item-section>
      </q-item>

      <q-separator inset="item" />
    </q-list>
  </div>
</template>

<script setup>
  const props = defineProps({
    chatdata: Object,
  })
</script>