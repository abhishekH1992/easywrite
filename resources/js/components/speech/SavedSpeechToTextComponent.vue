<template>
	<div class="chatbox-container document-container-chat">
        <div class="chatbox-body-main">
            <chat-head :name="pageInfo.name" :saved-id="pageInfo.id" @name-changes="nameChange" ref="chatHeader"/>
            <div class="chatbox-body">
                <div class="chat-container" ref="chatContainer">
                    <div class="bottom-bar">
                        <div class="chat">
                            <textarea ref="textarea" class="chat-textarea" :placeholder="`Ask something about audio`" v-model="msg" rows="1" @keydown.enter.exact.prevent="submit()"></textarea>
                            <div class="storeBtns" v-if="pageInfo.id">
                                <div class="input-btn">
                                    <button class="btn btn-bookmark btn-img" @click="save"><i class='fa fa-save'></i><span> Save</span></button>
                                    <button class="btn btn-clean btn-img" @click="clean"><i class="fa fa-refresh" aria-hidden="true"></i><span> Clear</span></button>
                                    <button class="btn btn-delete" @click="remove()"><i class="fa-solid fa-trash"></i><span> Delete</span></button>
                                </div>
                                <div class="storeBtnsInside">
                                    <div class="paperpin" @click="openDocument">
                                        <i class="fa-solid fa-microphone"></i>
                                    </div>
                                    <div class="submitBtn" @click="submit">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <audio-box :list="chatList" :typing="typing" :translate-language="translateLanguage" :class="`inputChat`"/>
                </div>
                <div class="editor-section" ref="editor">
                    <div class="close-document" @click="closeDocument">
                        <i class="fa-solid fa-times" aria-hidden="true"></i>
                    </div>
                    <saved-audio-list @show-loader="showLoader" />
                </div>
                <div class="loader-container" v-if="setLoader">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ChatHead from '../design/ChatHead.vue';
import SavedAudioList from '../design/SavedAudioList.vue';
import AudioBox from '../design/AudioBox.vue';
export default {
    data() {
        return {
            msg: '',
            setLoader: false,
            name: '',
            typing: false,
            isFirstMsg: true,
            isDocOpen: false,
        }
    },
    components: {
        ChatHead,
        SavedAudioList,
        AudioBox,
    },
    computed: {
        pageInfo() {
            return this.$store.state.speech.pageInfo;
        },
        chatList() {
            return this.$store.state.speech.chatList;
        },
        translateLanguage() {
            return this.$store.state.chat.translateLanguage;
        },
    },
    methods: {
        getPageInfo() {
            let payload = {
                id: this.$route.params.id,
            };
            this.$store
                .dispatch('speech/get_speech_to_text_info', payload);
        },
        showLoader(value) {
            this.setLoader = value;
        },
        nameChange(val) {
            this.name = val;
            this.save(true);
        },
        remove() {
            this.$store.dispatch('speech/remove', { id: this.pageInfo.id })
                .then((response) => {
                    if(response.data) {
                        this.$notify({
                            group: 'success',
                            text: 'Deleted!',
                            closeOnClick: true,
                        });
                        this.$router.push({ name: 'speechToText'});
                    } else {
                        this.$notify({
                            group: 'error',
                            text: 'Something went wrong! Please reload the page.',
                            closeOnClick: true,
                        });
                        this.$router.push({ name: 'speechToText'});
                    }
            });
        },
        submit() {
            this.typing = true;
            let msg = this.msg;
            let user = {
                msg: msg,
                user: 'user'
            };

            this.$store
                .dispatch('speech/set_user_msg', user).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                });
            
            this.msg = '';
            let previouChat = '';
            
            if(this.chatList.length){
                this.chatList.map((l) => {
                    previouChat = previouChat+l.msg;
                })
                msg = previouChat;
            }

            let paylaod = {
                msg: msg,
                slug: '/speech-to-text',
                history: 1,
            };
            this.$store
                .dispatch('speech/chat', paylaod).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                    this.typing = false;
                    this.isFirstMsg = false;
                });
        },
        save(){
            let payload = {
                id: this.pageInfo.id,
                list: this.chatList,
                name: this.name ? this.name : this.pageInfo.name,
            };

            this.$store.dispatch('speech/save', payload).then((response) => {
                this.name = '';
                this.$notify({
                    group: 'success',
                    text: 'Success! Saved.',
                    closeOnClick: true,
                });
                this.$router.push({ name: 'savedSpeechToText', params: { documentid: this.$route.params.id }});
                this.getPageInfo();
            });
        },
        nameChange(val) {
            this.name = val;
            this.save(true);
        },
        clean() {
            this.$store.dispatch('speech/clean');
            this.isFirstMsg = true;
            this.typing = false;
        },
        closeDocument() {
            this.isDocOpen = false;
            this.$refs.editor.classList.remove('mobile-editor');
            this.$refs.chatContainer.classList.remove('remove-editor');
        },
        openDocument() {
            if (this.isDocOpen) {
                this.isDocOpen = false;
                this.$refs.editor.classList.remove('mobile-editor');
                this.$refs.chatContainer.classList.remove('remove-editor');
            } else {
                this.isDocOpen = true;
                this.$refs.editor.classList.add('mobile-editor');
                this.$refs.chatContainer.classList.add('remove-editor');
            }
        },
    },
    mounted() {
        this.clean();
        this.getPageInfo();
        this.$store.dispatch('chat/translate_language');
    },
    watch: {
        $route(to, from) {
            this.clean();
            this.getPageInfo();
            this.$store.dispatch('chat/translate_language');
        }
    }
}
</script>