<template>
    <div class="chat-body">
        <div class="wrapper" v-for="(chat, i) in list" :key="i" :class="{blueBackground: i % 2 !== 0}">
            <div class="chat">
                <div class="profile user" v-if="chat.user === `user`">
                    <img src="/assets/images/user.svg">
                </div>
                <div class="profile ai" v-else>
                    <img src="/assets/images/bot.svg">
                </div>
                <div class="message" v-html="chat.msg"></div>
                <div class="copy">
                    <span @click="copytxt(chat.msg)">Copy</span>
                    <span @click="emailTxt(chat.msg)">Email</span>
                </div>
                <div class="copy-inline">
                    <span @click="copytxt(chat.msg)">Copy</span>
                    <span @click="emailTxt(chat.msg)">Email</span>
                </div>
            </div>
        </div>
        <div class="wrapper blueBackground" v-if="typing">
            <div class="chat">
                <div class="profile ai">
                    <img src="/assets/images/bot.svg">
                </div>
                <div class="message">typing<span>...</span></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        typing: {
            required: true,
        },
        list: {
            required: true,
        },
    },
    methods: {
        copytxt(txt) {
            navigator.clipboard.writeText(txt);
        },
        emailTxt(txt) {
            var mailToLink = "mailto:?body=" + encodeURIComponent(txt);
            window.location.href = mailToLink;
        },
    },
}
</script>