<template>
    <div class="chat-container">
        <chat-head :name="pageName" :img="pageImg"/>
        <div class="chat-body" v-if="!isTextarea">
            <div class="wrapper" v-if="preText">
                <div class="chat">
                    <div class="message">{{ preText }}</div>
                </div>
            </div>
            <div class="wrapper" v-for="(chat, i) in list" :key="i">
                <div class="chat">
                    <div class="message" :style="chat.user === `ai` && style ? style : ''">{{ chat.msg }}</div>
                </div>
            </div>
            <div class="wrapper" v-if="isTyping">
                <div class="chat">
                    <div class="message">typing...</div>
                </div>
            </div>
        </div>
        <div class="bottom-bar" v-if="!isTextarea">
            <div class="chat">
                <input type="text" :placeholder="placeholder" v-model="msg" @keydown.enter="submit"/>
                <button @click="submit"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
        <div class="chat-body is-textarea" v-if="isTextarea">
            <vue-editor :editorToolbar="customToolbar" v-model="textareaChat"/>
            <div class="textarea-btn">
                <button class="btn btn-success" @click="submitTextarea">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
import ChatHead from '../design/ChatHead.vue'
import { VueEditor } from "vue3-editor";
export default {
    data: () => ({
        msg: '',
        isTyping: false,
        customToolbar: [
            ["bold", "italic", "underline"]
        ],
        textareaChat: '',
    }),
    components: {
        ChatHead,
        VueEditor
    },
    computed: {
        list() {
            return this.$store.state.chat.list;
        },
        pageName() {
            return this.$store.state.chat.pageName;
        },
        pageImg() {
            return this.$store.state.chat.pageImg;
        },
        preText() {
            return this.$store.state.chat.preText;
        },
        placeholder() {
            return this.$store.state.chat.placeholder;
        },
        prefix() {
            return this.$store.state.chat.prefix;
        },
        style() {
            return this.$store.state.chat.style;
        },
        isTextarea() {
            return this.$store.state.chat.isTextarea;
        },
        // textareaChat() {
        //     return this.$store.state.chat.textareaChat;
        // },
    },
    methods: {
        getPageInfo() {
            let payload = {
                slug: this.$route.fullPath,
            };
            this.$store
                .dispatch('chat/page_info', payload);
        },
        submit() {
            this.isTyping = true;
            let msg = this.msg;
            this.msg = '';
            let user = {
                msg: this.prefix ? this.prefix+' '+msg : msg,
            }
            this.$store
                .dispatch('chat/set_user_msg', user).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                });

            let paylaod = {
                msg: this.prefix ? this.prefix+' '+msg : msg,
                slug: this.$route.fullPath,
                history: 1,
            };
            this.$store
                .dispatch('chat/chat', paylaod).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                    this.isTyping = false;
                });
        },
        submitTextarea() {
            this.isTyping = true;

            let paylaod = {
                msg: this.textareaChat,
                slug: this.$route.fullPath,
                history: 1,
                isTextarea: 1,
            };
            this.$store
                .dispatch('chat/chat_textarea', paylaod).then((response) => {
                    this.textareaChat = this.textareaChat+response.data;
                    var container = this.$el.querySelector(".ql-editor");
                    container.scrollTop = container.scrollHeight;
                    this.isTyping = false;
                });
        },
        textareaPretext() {
            let payload = {
                slug: this.$route.fullPath,
            };
            this.$store
                .dispatch('chat/page_textarea_pretext', payload).then((response) => {
                    this.textareaChat = response.data.pretext;
                });
        }
    },
    mounted() {
        this.$store.dispatch('chat/reset_state');
        this.getPageInfo();
        this.textareaPretext();
    },
    watch: {
        $route(to, from) {
            this.$store.dispatch('chat/reset_state');
            this.getPageInfo();
            this.textareaPretext();
        }
    }
}
</script>