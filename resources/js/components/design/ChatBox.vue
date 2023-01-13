<template>
    <div class="chat-body" :class="{isTextarea : pageInfo.isTextarea}">
        <div class="wrapper" v-if="pageInfo.pretext && !pageInfo.isTextarea">
            <div class="chat">
                <div class="message">{{ pageInfo.pretext }}</div>
            </div>
        </div>
        <div class="wrapper" v-for="(chat, i) in list" :key="i">
            <div class="chat" v-if="pageInfo.isFreechat">
                <div class="profile user" v-if="chat.user === `user` ">
                    <img src="/assets/images/user.svg">
                </div>
                <div class="profile ai" v-else>
                    <img src="/assets/images/bot.svg">
                </div>
                <div class="message">{{ chat.msg }}</div>
            </div>
            <div class="chat" v-else>
                <div class="message" :style="chat.user === `ai` && pageInfo.style ? pageInfo.style : ''" v-html="chat.msg"></div>
            </div>
        </div>
        <div class="wrapper" v-if="typing">
            <div class="chat">
                <div class="profile ai" v-if="pageInfo.isFreechat">
                    <img src="/assets/images/bot.svg">
                </div>
                <div class="message">typing...</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        pageInfo: {
            required: true,
        },
        typing: {
            required: true,
        },
    },
    computed: {
        list() {
            return this.$store.state.chat.list;
        },
    },
}
</script>