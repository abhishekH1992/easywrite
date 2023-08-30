<template>
    <div class="chatbox-container">
        <div class="chatbox-body-main">
            <chat-head :name="pageInfo.name" :outline="pageInfo.outline" ref="chatHeader"/>
            <div class="chatbox-body">
                <div class="chat-container" :class="{fillWidthChatContainer: isEditorOpen}">
                    <div class="bottom-bar" v-if="!pageInfo.isTextarea">
                        <div class="chat">
                            <textarea ref="textarea" class="chat-textarea" :placeholder="`Ask..`" v-model="msg" rows="1" @keydown.enter.prevent="submit()"></textarea>
                            <div class="storeBtns">
                                <div class="submitBtn" @click="submit()">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <chat-box :list="chatList" :page-info="pageInfo" :typing="typing" :translate-language="translateLanguage" :show-user-icons="true"/>
                    <div class="edit-tab" @click="isEditorOpen = !isEditorOpen"><i class="fa fa-pencil" aria-hidden="true"></i> Editor</div>
                </div>
                <div class="editor-section" :class="{editorHide: isEditorOpen}">
                    <vue-editor v-model="editor" :editorToolbar="customToolbar"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ChatHead from '../design/ChatHead.vue';
import ChatBox from '../design/ChatBox.vue';
import { VueEditor } from "vue3-editor";

export default {
    data: () => ({
        msg: '',
        typing: false,
        customToolbar: [
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ["bold", "italic", "underline", "strike"],
            ['blockquote', 'code-block'],
            [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
        ],
        isFirstMsg: true,
        editor: '',
        textAreaHeight: 0,
        isEditorOpen: false,
        availableHeight: '50vh',
    }),
    components: {
        ChatBox,
        VueEditor,
        ChatHead
    },
    computed: {
        pageInfo() {
            return this.$store.state.chatSuite.sectionPageInfo;
        },
        translateLanguage() {
            return this.$store.state.chat.translateLanguage;
        },
        chatList() {
            return this.$store.state.chatSuite.chatList;
        },
    },
    methods: {
        async getPageInfo() {
            await this.$store
                .dispatch('chatSuite/get_page_info_section', this.$route.params.slug);
        },
        clean() {
            this.$store.dispatch('chatSuite/clean_chat');
            this.isFirstMsg = true;
            this.typing = false;
        },
        submit() {
            this.typing = true;
            let msg = this.msg;
            let user = {
                msg: msg,
                user: 'user'
            };

            this.$store
                .dispatch('chatSuite/set_user_msg', user).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                });
            
            this.msg = '';
            // let previouChat = '';
            
            // if(this.chatList.length){
            //     this.chatList.map((l) => {
            //         previouChat = previouChat+l.msg;
            //     })
            //     msg = previouChat;
            // }

            let paylaod = {
                msg: {
                    role: 'user',
                    content: msg
                },
                id: this.pageInfo.id
            };
            this.$store
                .dispatch('chatSuite/chat', paylaod).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                    this.typing = false;
                    this.isFirstMsg = false;
                });
        },
        mountedList() {
            var container = this.$el.querySelector(".chat-body");
            container.scrollTop = container.scrollHeight;
            this.$store.dispatch('chat/reset_state');
            this.$store.dispatch('chat/translate_language');
            this.getPageInfo();
        },
    },
    mounted() {
        this.mountedList();
    },
    watch: {
        $route(to, from) {
            this.mountedList();
        },
        msg() {
            this.$refs.textarea.style.height="auto";
            this.$nextTick(() => {
                this.textAreaHeight = this.textAreaHeight <=93 ? this.$refs.textarea.scrollHeight : this.textAreaHeight;
                this.$refs.textarea.style.height = this.textAreaHeight + 'px';
            });
        },
    },
}
</script>