<template>
    <div class="chatbox-container">
        <div class="chatbox-body-main">
            <chat-head :name="chatName" :img="pageInfo.img" :outline="pageInfo.outline" :saved-id="savedId" @name-changes="nameChange" ref="chatHeader"/>
            <div class="chatbox-body">
                <div class="chat-container" :class="{fillWidthChatContainer: isEditorOpen}">
                    <div class="bottom-bar" v-if="!pageInfo.isTextarea">
                        <div class="chat">
                            <!-- <input type="text" :placeholder="pageInfo.placeholder" v-model="msg" @keydown.enter="submit"/> -->
                            <textarea ref="textarea" class="chat-textarea" :placeholder="pageInfo.placeholder" v-model="msg" rows="1" @keydown.enter.exact.prevent="submit()"></textarea>
                            <!-- <vue-editor v-model="msg" :placeholder="pageInfo.placeholder" @keydown.enter.exact.prevent="submit()"/> -->
                            <div class="storeBtns">
                                <div class="input-btn">
                                    <button class="btn btn-bookmark btn-img" @click="save"><i class='fa fa-save'></i><span> Save</span></button>
                                    <button class="btn btn-clean btn-img" @click="clean"><i class="fa fa-refresh" aria-hidden="true"></i><span> Clear</span></button>
                                    <button class="btn btn-delete" @click="destroy" v-if="savedId"><i class="fa-solid fa-trash"></i><span> Delete</span></button>
                                </div>
                                <div class="submitBtn" @click="submit">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-bar-textarea" v-if="pageInfo.isTextarea" ref="bottomBarTextarea">
                        <div class="chat">
                            <div class="fieldset" v-for="(field, i) in fieldSet" :key="i">
                                <div class="field" v-if="field.type == 'textarea'">
                                    <label>{{ field.label }}</label>
                                    <textarea :placeholder="field.placeholder" v-model="combineMsg[field.label]" rows="1"></textarea>
                                </div>
                                <div class="field" v-if="field.type == 'input'">
                                    <label>{{ field.label }}</label>
                                    <input type="text" :placeholder="field.placeholder" v-model="combineMsg[field.label]" class="form-control"/>
                                </div>
                            </div>
                            <div class="textarea-btn">
                                <div class="input-btn">
                                    <button class="btn btn-bookmark btn-img" @click="save"><i class='fa fa-save'></i><span> Save</span></button>
                                    <button class="btn btn-clean btn-img" @click="clean"><i class="fa fa-refresh" aria-hidden="true"></i><span> Clear</span></button>
                                    <button class="btn btn-delete" @click="destroy" v-if="savedId"><i class="fa-solid fa-trash"></i><span> Delete</span></button>
                                </div>
                                <div class="submitBtn" @click="submit">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <chat-box :list="list" :page-info="pageInfo" :typing="typing" :translate-language="translateLanguage" v-if="pageInfo && !pageInfo.isTextarea" />
                    <chat-box class="one" :list="list" :page-info="pageInfo" :typing="typing" :translate-language="translateLanguage" v-if="pageInfo && pageInfo.isTextarea && availableHeight" :style="{ maxHeight: availableHeight + 'px' }"/>
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
        combineMsg: [],
        isTextareaMsg: '',
        editor: '',
        name: '',
        savedId: 0,
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
            return this.$store.state.chat.pageInfo;
        },
        fieldSet() {
            return JSON.parse(this.pageInfo.fieldset);
        },
        list() {
            return this.$store.state.chat.list;
        },
        translateLanguage() {
            return this.$store.state.chat.translateLanguage;
        },
        chatName() {
            return this.name ? this.name : this.pageInfo.name;
        },
    },
    methods: {
        async getPageInfo() {
            let payload = {
                slug: this.$route.fullPath,
            };
            await this.$store
                .dispatch('chat/get_page_info', payload).then((response) => {
                    if(this.$route.params.id){
                        this.getSavedChat();
                        this.isFirstMsg = this.pageInfo.isSystem ? true : false;
                    } else {
                        this.isFirstMsg = true;
                    }
                    this.isTextareaMsg = '';
                    this.combineMsg = [];
                    this.name = '';
                    this.savedId = '';
                    this.setTextAreaHeight();
                });
        },
        submit() {
            this.typing = true;
            let msg = this.msg;
            let user = '';
            if (!this.pageInfo.isTextarea) this.$refs.textarea.style.height="auto";
            if(this.pageInfo.isFreechat){
                user = {
                    msg: this.pageInfo.prefix ? this.pageInfo.prefix+' '+msg : msg,
                    user: 'user'
                }
            } else {
                if(this.pageInfo.isTextarea){
                    Object.entries(this.combineMsg).map((combine, i) => {
                        this.isTextareaMsg = this.isTextareaMsg+'<p>'+combine.join(': ')+'</p>'
                    });
                    user = {
                        msg: this.isTextareaMsg
                    }
                } else {
                    user = {
                        msg: this.pageInfo.prefix ? this.pageInfo.prefix+' '+msg : msg
                    }
                }
            }

            this.$store
                .dispatch('chat/set_user_msg', user).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                });

            this.msg = '';
            let previouChat = '';
            if(this.isFirstMsg && this.pageInfo.isSystem){
                if(this.pageInfo.history) {
                    this.list.map((l) => {
                        previouChat = previouChat+l.msg;
                    })
                }
                msg = this.pageInfo.isSystem ? this.pageInfo.system+previouChat : msg;
            } else if(this.isFirstMsg && !this.pageInfo.isTextarea){
                msg = this.pageInfo.pretext ? this.pageInfo.pretext+msg : msg;
            } else if(this.isFirstMsg && this.pageInfo.isTextarea){
                msg = this.pageInfo.pretext ? this.pageInfo.pretext+this.isTextareaMsg : this.isTextareaMsg;
            } else if(this.pageInfo.isTextarea){
                msg = this.pageInfo.pretext ? this.pageInfo.pretext+this.isTextareaMsg : this.isTextareaMsg;
            }

            // msg = localStorage.getItem('language') ? msg+' Language: '+localStorage.getItem('language')+' ' : msg;
            // msg = localStorage.getItem('tone') ? msg+' Tone: '+localStorage.getItem('tone')+' ' : msg;

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
                    this.isTextareaMsg = '';
                    this.combineMsg = [];
                    this.isFirstMsg = false;
                });
        },
        clean() {
            this.$store.dispatch('chat/clean_chat');
            this.isTextareaMsg = '';
            this.combineMsg = [];
            this.isFirstMsg = true;
            this.typing = false;
        },
        save(){
            let type = this.pageInfo.isSystem ? 'custom-chat' : 'model';
            let payload = {
                editor: this.editor,
                slug: '/'+type+'/'+this.$route.params.prompt,
                list: this.list,
                id: this.savedId,
                name: this.name,
                tone: localStorage.getItem('tone'),
                language: localStorage.getItem('language'),
            };

            this.$store.dispatch('chat/save', payload).then((response) => {
                this.$notify({
                    group: 'success',
                    text: 'Success! Saved.',
                    closeOnClick: true,
                });
                let comp = this.pageInfo.isSystem ? 'savedCustomChatBox' : 'savedChatBox';
                this.$router.push({ name: comp, params: { prompt: this.$route.params.prompt, id: response.data.id }});
            });
        },
        getSavedChat(){
            let payload = {
                id: this.$route.params.id
            };
            this.$store.dispatch('chat/get_user_chat', payload).then((response) => {
                if(Object.keys(response.data).length){
                    this.$store.dispatch('chat/set_user_chat', JSON.parse(response.data.list));
                    this.name = response.data.name;
                    this.editor = response.data.editor;
                    this.savedId = response.data.id;
                    if (response.data.langauge) {
                        localStorage.setItem('language', response.data.langauge);
                    }
                    if (response.data.tone) {
                        localStorage.setItem('tone', response.data.tone);
                    }
                }
            });
        },
        destroy() {
            let payload = {
                id: this.savedId
            };
            this.$store.dispatch('chat/delete_user_chat', payload).then((response) => {
                this.$notify({
                    group: 'success',
                    text: 'Deleted! Chat deleted.',
                    closeOnClick: true,
                });
                this.$router.push({ name: 'chatBox', params: { prompt: this.$route.params.prompt }});
            });
        },
        mountedList() {
            var container = this.$el.querySelector(".chat-body");
            container.scrollTop = container.scrollHeight;
            this.$store.dispatch('chat/reset_state');
            this.$store.dispatch('chat/translate_language');
            this.getPageInfo();
        },
        nameChange(val) {
            this.name = val;
            this.save();
        },
        setTextAreaHeight() {
            // console.log(this.$refs.bottomBarTextarea[0]);
            let screen = window.innerHeight;
            let chatHeader = this.$refs.chatHeader.$el.clientHeight;
            // let bottomBarTextarea = this.$refs.bottomBarTextarea.$el.clientHeight;
            this.availableHeight = screen - (chatHeader + 270);
            console.log(this.availableHeight);
        }
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