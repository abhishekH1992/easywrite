<template>
    <div class="chatbox-container support-chat">
        <div class="chatbox-body-main">
            <chat-head :name="pageInfo.name" :outline="pageInfo.outline" ref="chatHeader"/>
            <div class="chatbox-body">
                <div class="chat-container">
                    <div class="bottom-bar">
                        <div class="chat">
                            <textarea ref="textarea" class="chat-textarea" :placeholder="`Ask..`" v-model="msg" rows="1" @keydown.enter.exact.prevent="submit()"></textarea>
                            <div class="storeBtns">
                                <div class="input-btn"></div>
                                <div class="submitBtn" @click="submit">
                                    <i class="fa fa-paper-plane" aria-hidden="true" title="Send message"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <chat-box :list="chatList" :typing="typing" :class="`inputChat`"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ChatHead from '../design/ChatHead.vue';
import { VueEditor } from "vue3-editor";
import ChatBox from "../design/FreeDocumentChatBox.vue";

export default {
    data() {
        return {
            msg: '',
            typing: false,
        }
    },
    computed: {
        pageInfo() {
            return this.$store.state.freeDocumentChat.pageInfo;
        },
        chatList() {
            return this.$store.state.freeDocumentChat.chatList;
        }
    },
    components: {
        ChatHead,
        VueEditor,
        ChatBox
    },
    methods: {
        mountedList() {
            this.$store
                    .dispatch('freeDocumentChat/get_page_info', this.$route.params.slug);
        },
        submit() {
            let msg = this.msg;
            let user = {
                msg: msg,
                user: 'user',
            };

            this.$store
                .dispatch('freeDocumentChat/set_user_msg', user);
                
            this.typing = true;
            this.msg = '';
                
            let payload = {
                msg: msg,
                document_id: this.pageInfo.document_id,
            }
            this.$store.dispatch('freeDocumentChat/document_chat', payload).then((response) => {
                this.typing = false;
            });
        },
    },
    mounted() {
        this.mountedList();
    },
    watch: {
        $route(to, from) {
            this.mountedList();
        }
    },
}
</script>