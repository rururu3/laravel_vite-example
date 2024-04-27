<template>
  <div>
    <ChatItem v-for="item of items" :chatdata="item"></ChatItem>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import ChatItem from './ChatItem.vue'

  const items = ref([]);

  window.Echo.channel("test-channel").listen("TestEvent", function (e) {
    items.value.push({
      name: 'name',
      title: 'title',
      message: 'message',
      date: 'date'
    });
  });
</script>