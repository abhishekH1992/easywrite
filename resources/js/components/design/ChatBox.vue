<template>
    <div class="chat-container">
        <chat-head :name="`Freechat`" :img="`/assets/images/freechat.svg`"/>
        <div class="chat-body">
            <div class="wrapper" v-for="(chat, i) in list" :key="i">
                <div class="chat">
                    <div class="profile user" v-if="chat.user === `user`">
                        <img src="/assets/images/user.svg">
                    </div>
                    <div class="profile ai" v-else>
                        <img src="/assets/images/bot.svg">
                    </div>
                    <div class="message">{{ chat.msg }}</div>
                </div>
            </div>
            <div class="wrapper" v-if="isTyping">
                <div class="chat">
                    <div class="profile ai">
                        <img src="/assets/images/bot.svg">
                    </div>
                    <div class="message">typing...</div>
                </div>
            </div>
        </div>
        <div class="bottom-bar">
            <div class="chat">
                <input type="text" placeholder="Type a message..." v-model="msg" @keydown.enter="submit"/>
                <button @click="submit"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
import ChatHead from '../design/ChatHead.vue'
export default {
    data: () => ({
        msg: '',
        isTyping: false,
    }),
    components: {
        ChatHead
    },
    computed: {
        list() {
            return this.$store.state.chat.list;
        },
    },
    methods: {
        submit() {
            this.isTyping = true;
            let msg = this.msg;
            this.msg = '';
            let user = {
                msg: msg,
                user: 'user'
            }
            this.$store
                .dispatch('chat/set_user_msg', user).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                });

            let paylaod = {
                msg: msg,
                slug: this.$route.fullPath,
                history: 1,
            };
            this.$store
                .dispatch('chat/chat', paylaod).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                    this.isTyping = false;
                });
        }
    },
}
</script>