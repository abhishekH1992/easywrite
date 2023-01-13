<template>
    <div class="chatbox-container">
        <div class="chatbox-body">
            <div class="chat-container">
                <chat-head :name="pageInfo.name" :img="pageInfo.img"/>
                <chat-box :page-info="pageInfo" :msg="msg" :typing="typing" v-if="pageInfo"/>
                <div class="bottom-bar" v-if="!pageInfo.isTextarea">
                    <div class="chat">
                        <input type="text" :placeholder="pageInfo.placeholder" v-model="msg" @keydown.enter="submit"/>
                        <button @click="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
                <div class="bottom-bar-textarea" v-if="pageInfo.isTextarea">
                    <div class="chat">
                        <vue-editor :editorToolbar="customToolbar" v-model="msg"/>
                        <div class="textarea-btn">
                            <button class="btn btn-success" @click="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <vue-editor/>
        </div>
    </div>
</template>
<script>
import ChatHead from '../design/ChatHead.vue'
import ChatBox from '../design/ChatBox.vue'
import { VueEditor } from "vue3-editor";

export default {
    data: () => ({
        msg: '',
        typing: false,
        customToolbar: [
            ["bold", "italic", "underline"]
        ],
        isFirstMsg: true,
    }),
    components: {
        ChatBox,
        VueEditor,
        ChatHead,
    },
    computed: {
        pageInfo() {
            return this.$store.state.chat.pageInfo;
        },
    },
    methods: {
        getPageInfo() {
            let payload = {
                slug: this.$route.fullPath,
            };
            this.$store
                .dispatch('chat/get_page_info', payload).then((response) => {
                    this.msg = this.pageInfo.isTextarea && this.pageInfo.pretext ? this.pageInfo.pretext : '';
                });
        },
        submit() {
            this.typing = true;
            let msg = this.msg;
            this.msg = this.pageInfo.isTextarea && this.pageInfo.pretext ? this.pageInfo.pretext : '';
            let user = '';
            if(this.pageInfo.isFreechat){
                user = {
                    msg: this.pageInfo.prefix ? this.pageInfo.prefix+' '+msg : msg,
                    user: 'user'
                }
            } else {
                user = {
                    msg: this.pageInfo.prefix ? this.pageInfo.prefix+' '+msg : msg
                }
            }
            this.$store
                .dispatch('chat/set_user_msg', user).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                });
            if(this.isFirstMsg){
                msg = this.pageInfo.pretext ? this.pageInfo.pretext+msg : msg;
                this.isFirstMsg = false;
            }

            let paylaod = {
                msg: msg,
                slug: this.$route.fullPath,
                history: this.pageInfo.history,
            };
            this.$store
                .dispatch('chat/chat', paylaod).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                    this.typing = false;
                });
        },
    },
    mounted() {
        this.$store.dispatch('chat/reset_state');
        this.getPageInfo();
        this.isFirstMsg = true;
    },
    watch: {
        $route(to, from) {
            this.$store.dispatch('chat/reset_state');
            this.getPageInfo();
            this.isFirstMsg = true;
        }
    }
}
</script>