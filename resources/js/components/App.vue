<template>
  <div>
    <label for="message">メッセージ</label>
    <input type="text" id="message" name="message" v-model="sendMessage" />
    <button id="send" @click="send">送信</button>
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