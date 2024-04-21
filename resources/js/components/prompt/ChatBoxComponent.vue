<template>
    <div class="chatbox-container">
        <div class="chatbox-body-main">
            <chat-head :name="chatName" :img="pageInfo.img" :outline="pageInfo.outline" :saved-id="savedId" @name-changes="nameChange" ref="chatHeader"/>
            <div class="chatbox-body">
                <div class="chat-container" :class="{fillWidthChatContainer: isEditorOpen}">
                    <div class="bottom-bar" :class="pageInfo.isPythonSuggestions ? `bottom-bar-python` : ``" v-if="!pageInfo.isTextarea">
                        <div class="chat">
                            <textarea ref="textarea" class="chat-textarea" :placeholder="pageInfo.placeholder" v-model="msg" rows="1" @keydown.enter.exact.prevent="submit()" v-if="!pageInfo.isPythonSuggestions"></textarea>
                            <div class="storeBtns">
                                <div class="input-btn">
                                    {{ pageInfo.is_image_editor }}
                                    <button class="btn btn-bookmark btn-img" @click="save"><i class='fa fa-save' title="Save"></i></button>
                                    <button class="btn btn-clean btn-img" @click="clean"><i class="fa fa-refresh" aria-hidden="true" title="Clear"></i></button>
                                    <button class="btn btn-delete" @click="destroy" v-if="savedId"><i class="fa-solid fa-trash" title="Delete"></i></button>
                                </div>
                                <div class="submitBtn" @click="submit" v-if="!pageInfo.isPythonSuggestions">
                                    <i class="fa fa-paper-plane" aria-hidden="true" title="Send message"></i>
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
                                <div class="field" v-if="field.type == 'file'">
                                    <label>{{ field.label }}</label>
                                    <input type="file" :placeholder="field.placeholder" class="form-control" ref="editImage" :accept="field.accept" @change="onFileChange"/>
                                </div>
                            </div>
                            <div class="textarea-btn">
                                <div class="input-btn">
                                    <button class="btn btn-bookmark btn-img" @click="save" v-if="!pageInfo.is_image_editor"><i class='fa fa-save' title="Save"></i></button>
                                    <button class="btn btn-clean btn-img" @click="clean"><i class="fa fa-refresh" aria-hidden="true" title="Clear"></i></button>
                                    <button class="btn btn-delete" @click="destroy" v-if="savedId"><i class="fa-solid fa-trash" title="Delete"></i></button>
                                </div>
                                <div class="submitBtn" @click="submit">
                                    <i class="fa fa-paper-plane" aria-hidden="true" title="Send message"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <chat-box :list="list" :page-info="pageInfo" :typing="typing" :translate-language="translateLanguage" v-if="pageInfo && !pageInfo.isTextarea && !pageInfo.isPythonSuggestions" @related-question-selected="relatedQuestion" @div-link="showInBrowser"/>
                    <chat-box class="one" :list="list" :page-info="pageInfo" :typing="typing" :translate-language="translateLanguage" v-if="pageInfo && pageInfo.isTextarea && availableHeight" :style="{ maxHeight: availableHeight + 'px' }"/>
                    <!-- <vue-editor v-model="editor" :editorToolbar="customToolbar" v-if="pageInfo.isPythonSuggestions" :class="`text-completion`" @keydown.tab.exact.prevent="submit()"/> -->
                    <div class="chat-body">
                        <div class="chat">
                            <textarea v-model="editor" placeholder="Start typing and press tab for suggestions..." v-if="pageInfo.isPythonSuggestions" :class="`text-completion`" @keydown.tab.exact.prevent="submit()" :style="{ height: suggestionTextAreaHeight + 'px' }" />
                        </div>
                    </div>
                    <div class="edit-tab" @click="isEditorOpen = !isEditorOpen" v-if="pageInfo.isPythonSuggestions"><i class="fa fa-pencil" aria-hidden="true"></i> Suggestions</div>
<!-- <div class="edit-tab" @click="isEditorOpen = !isEditorOpen" v-else><i class="fa fa-pencil" aria-hidden="true"></i> Editor</div> -->
                    <div class="edit-tab-section" v-else-if="pageInfo.isWebpage">
                        <div class="edit-tab-block" @click="showPanel('editor')"><i class="fa fa-pencil" aria-hidden="true"></i> Editor</div>
                        <div class="edit-tab-block" @click="showPanel('webpage')"><i class="fa fa-snowflake" aria-hidden="true"></i> Webpage</div>
                    </div>
                    <div class="edit-tab" @click="isEditorOpen = !isEditorOpen" v-else><i class="fa fa-pencil" aria-hidden="true"></i> Editor</div>
                </div>
                <div class="editor-section python-suggestions-section" :class="{editorHide: isEditorOpen, borderRight: pageInfo.is_image_editor}">
                    <PinturaEditor
                        v-bind="editorDefaults"
                        :src="src"
                        :imageCropAspectRatio="imageCropAspectRatio"
                        v-on:pintura:process="handleEditorProcess($event)"
                        v-if="pageInfo.is_image_editor"
                    ></PinturaEditor>
                    <div class="python-suggestions m-4" v-else-if="pageInfo.isPythonSuggestions">
                        <!-- <p class="suggestion-text-bold my-3">Suggestions: </p> -->
                                <p class="message" v-if="typing">loading<span>...</span></p>
                        <div v-if="!typing">
                            <p v-for="(suggestion, key) in suggestions" :key="key">
                                <input type="radio" name="suggestions" :value="suggestion" v-model="pickedSuggection" /> <span v-html="suggestion"></span>
                            </p>
                        </div>
                    </div>
<!-- <vue-editor v-model="editor" :editorToolbar="customToolbar" v-else/> -->
                    <vue-editor v-model="editor" :editorToolbar="customToolbar" v-else-if="isShowEditor && pageInfo.isWebpage"/>
                    <div v-else-if="isBrowser && pageInfo.isWebpage" class="browser-frame">
                        <iframe :src="browserLink"></iframe>
                    </div>
                    <vue-editor v-model="editor" :editorToolbar="customToolbar" v-else/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ChatHead from '../design/ChatHead.vue';
import ChatBox from '../design/ChatBox.vue';
import { VueEditor } from "vue3-editor";
import { getEditorDefaults } from '@pqina/pintura';
import { PinturaEditor } from '@pqina/vue-pintura';
import '../../../../node_modules/@pqina/pintura/pintura.css';

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
        imageCropAspectRatio: 1,
        src: '/assets/images/EasyWrite.svg',
        editorDefaults: getEditorDefaults(),
        pickedSuggestion: null,
        suggestionTextAreaHeight: 500,
        isBrowser: false,
        isShowEditor: true,
        browserLink: '',
    }),
    components: {
        ChatBox,
        VueEditor,
        ChatHead,
        PinturaEditor,
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
        suggestions() {
            return this.$store.state.chat.suggestions;
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
                        this.editor = null;
                    }
                    this.isTextareaMsg = '';
                    this.combineMsg = [];
                    this.name = '';
                    this.savedId = 0;
                    this.setTextAreaHeight();
                });
        },
        submit() {
            this.typing = true;
            let msg = this.msg;
            let user = '';
            if (!this.pageInfo.isTextarea && !this.pageInfo.isPythonSuggestions) this.$refs.textarea.style.height="auto";
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
                    if(!this.pageInfo.isPythonSuggestions)
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
                msg: this.pageInfo.isPythonSuggestions ? this.editor : msg,
                slug: this.$route.fullPath,
                history: this.pageInfo.history,
                isPython: this.pageInfo.isPython,
                isPythonSuggestions: this.pageInfo.isPythonSuggestions,
            };
            this.$store
                .dispatch('chat/chat', paylaod).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    this.typing = false;
                    this.isTextareaMsg = '';
                    this.combineMsg = [];
                    this.isFirstMsg = false;
                    if(!this.pageInfo.isPythonSuggestions)
                        container.scrollTop = container.scrollHeight;
                });
        },
        clean() {
            this.$store.dispatch('chat/clean_chat');
            this.isTextareaMsg = '';
            this.combineMsg = [];
            this.isFirstMsg = true;
            this.typing = false;
            this.editor = null;
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
            this.$store.dispatch('chat/reset_state');
            this.$store.dispatch('chat/translate_language');
            this.getPageInfo();
            if(!this.pageInfo.isPythonSuggestions)
                container.scrollTop = container.scrollHeight;
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
        },
        handleEditorProcess(imageState) {
            let file = imageState.detail.dest;

            // Create a hidden link and set the URL using createObjectURL
            const link = document.createElement('a');
            link.style.display = 'none';
            link.href = window.URL.createObjectURL(file);
            link.download = file.name;

            // We need to add the link to the DOM for "click()" to work
            document.body.appendChild(link);
            link.click();

            // To make this work on Firefox we need to wait a short moment before clean up
            setTimeout(() => {
                URL.revokeObjectURL(link.href);
                link.parentNode.removeChild(link);
            }, 0);
        },
        onFileChange(e) {
            let file = e.target.files[0];
            this.src = window.URL.createObjectURL(file);
        },
        relatedQuestion(value) {
            this.msg = value;
        },
        showInBrowser(value) {
            if(value.includes('https')) {
                this.browserLink = value;
            } else {
                window.open(value, '_blank');
            }
        },
        showPanel(type) {
            // console.log(type);
            // this.isEditorOpen = !this.isEditorOpen;
            if (type == 'editor') {
                // if(this.isShowEditor) {
                //     this.isEditorOpen = false;
                //     this.isShowEditor = false;
                // } else {
                //     this.isEditorOpen = true;
                //     this.isShowEditor = true;
                // }
                this.isShowEditor = true;
                this.isBrowser = false;
            } else {
                // if(this.isBrowser) {
                //     this.isEditorOpen = false;
                //     this.isBrowser = false;
                // } else {
                //     this.isEditorOpen = true;
                //     this.isBrowser = true;
                // }
                // this.isShowEditor = false;
                this.isShowEditor = false;
                this.isBrowser = true;
            }
            return;
        },
        handlePickedSuggestion(suggestion) {
            if (this.pickedSuggestion !== suggestion) {
                this.editor = this.editor +' '+ suggestion;
                this.$store.commit('chat/set_suggestions', []);
            }
        },
    },
    mounted() {
        this.mountedList();
        this.suggestionTextAreaHeight = window.innerHeight * (80/100);
    },
    watch: {
        $route(to, from) {
            this.mountedList();
        },
        msg() {
            this.$refs.textarea.style.height="auto";
            this.$nextTick(() => {
                this.textAreaHeight = this.textAreaHeight <= 93 ? this.$refs.textarea.scrollHeight : this.textAreaHeight;
                this.$refs.textarea.style.height = this.textAreaHeight > 109 ? '109px' : this.textAreaHeight + 'px';
            });
        },
        pickedSuggestion(newValue, oldValue) {
            if(oldValue != newValue && newValue) {
                this.editor = this.editor +' '+ newValue;
                this.$store.commit('chat/set_suggestions', []);
            }
        }
    },
}
</script>