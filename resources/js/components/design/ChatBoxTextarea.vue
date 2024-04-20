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
                    <div class="message" :style="chat.user === `ai` && style ? style : ''" v-html="chat.msg"></div>
                    <div class="copy">
                        <span @click="copytxt(chat.msg)"><i class="far fa-copy" aria-hidden="true" title="Copy"></i></span>
                        <span @click="emailTxt(chat.msg)"><i class="far fa-envelope" aria-hidden="true" title="Email"></i></span>
                        <span @click="setTranslatePayload(chat.msg, i)"><i class="fa fa-language" aria-hidden="true" title="Translate"></i></span>
                    </div>
                    <div class="copy-inline">
                        <span @click="copytxt(chat.msg)"><i class="far fa-copy" aria-hidden="true" title="Copy"></i></span>
                        <span @click="setTranslatePayload(chat.msg, i)"><i class="fa fa-language" aria-hidden="true" title="Translate"></i></span>
                        <span @click="emailTxt(chat.msg)"><i class="far fa-envelope" aria-hidden="true" title="Email"></i></span>
                    </div>
                </div>
            </div>
            <div class="wrapper" v-if="isTyping">
                <div class="chat flex">
                    <div class='h-2.5 w-2.5 bg-current rounded-full mr-1 bounce 1s infinite'></div>
                    <div class='h-2.5 w-2.5 bg-current rounded-full mr-1 bounce 1s infinite 200ms'></div>
                    <div class='h-2.5 w-2.5 bg-current rounded-full bounce 1s infinite 400ms'></div>
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
        <div class="modal-mask" v-if="showModal">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h4>Select Language</h4>
                    </div>  
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6" v-for="(lang, key) in translateLanguage" :key="key">
                                <input type="radio" v-model="language" :value="{ code: lang.code, name: lang.name }"> {{ lang.name }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn theme-btn" @click="translate()">Translate</button>
                        <button class="btn theme-btn" @click="cancelTranslate()">Cancel</button>
                    </div>
                </div>
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
        txtToTranslate: '',
        keyToTranslate: null,
        showModal: false,
        language: {
            code: 'sm',
            name: 'Samoan'
        },
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
        translateLanguage() {
            return this.$store.state.chat.translateLanguage;
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
        },
        copytxt(txt) {
            navigator.clipboard.writeText(txt);
        },
        emailTxt(txt) {
            var mailToLink = "mailto:?body=" + encodeURIComponent(txt);
            window.location.href = mailToLink;
        },
        setTranslatePayload(txt, key) {
            this.txtToTranslate = txt;
            this.keyToTranslate = key;
            this.showModal = true;
        },
        cancelTranslate() {
            this.txtToTranslate = '';
            this.keyToTranslate = null;
            this.showModal = false;
        },
        translate() {
            let payload = {
                txt: this.txtToTranslate,
                language: this.language,
                key: this.keyToTranslate,
            }

            this.$store.dispatch('chat/translate_chat', payload);
            this.showModal = false;
        }
    },
    mounted() {
        this.$store.dispatch('chat/reset_state');
        this.$store.dispatch('chat/translate_language');
        this.getPageInfo();
        this.textareaPretext();
    },
    watch: {
        $route(to, from) {
            this.$store.dispatch('chat/reset_state');
            this.$store.dispatch('chat/translate_language');
            this.getPageInfo();
            this.textareaPretext();
        }
    }
}
</script>