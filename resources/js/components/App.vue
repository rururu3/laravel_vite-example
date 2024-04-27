<template>
  <div class="q-pa-md q-gutter-sm">
    <q-input rounded outlined v-model="sendMessage" label="メッセージ" >
      <q-btn round dense flat icon="send" @click="send" />
    </q-input>
    <ChatItem v-for="item of items" :chatdata="item"></ChatItem>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import ChatItem from './ChatItem.vue'

  const sendMessage = defineModel();
  const items = ref([]);

  window.Echo.channel("chat-message-channel").listen("ChatMessageEvent", function (e) {
    items.value.unshift({
      name: e?.name,
      title: e?.title,
      message: e?.message,
      date: e?.date,
    });
  });

  async function send(event) {
    const res = await axios.post("/chat", { message: sendMessage.value });
  }
</script>