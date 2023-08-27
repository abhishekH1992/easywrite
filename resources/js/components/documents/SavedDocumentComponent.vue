<template>
	<div class="chatbox-container document-container-chat">
        <div class="chatbox-body-main">
            <chat-head :name="pageInfo.name" :saved-id="pageInfo.id" @name-changes="nameChange" ref="chatHeader"/>
            <div class="chatbox-body">
                <div class="chat-container" ref="chatContainer">
                    <div class="bottom-bar">
                        <div class="chat">
                            <textarea ref="textarea" class="chat-textarea" :placeholder="`Ask something about document`" v-model="msg" rows="1" @keydown.enter.exact.prevent="submit()"></textarea>
                            <div class="storeBtns">
                                <div class="input-btn">
                                    <button class="btn btn-bookmark btn-img" @click="save"><i class='fa fa-save'></i><span> Save</span></button>
                                    <button class="btn btn-clean btn-img" @click="clean"><i class="fa fa-refresh" aria-hidden="true"></i><span> Clear</span></button>
                                    <button class="btn btn-delete" @click="remove(pageInfo.document_id, pageInfo.name)"><i class="fa-solid fa-trash"></i><span> Delete</span></button>
                                </div>
                                <div class="storeBtnsInside">
                                    <div class="paperpin" @click="openDocument">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                    </div>
                                    <div class="submitBtn" @click="submit">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <document-box :list="chatList" :typing="typing" :translate-language="translateLanguage" :class="`inputChat`"/>
                </div>
                <div class="editor-section" ref="editor">
                    <div class="close-document" @click="closeDocument">
                        <i class="fa-solid fa-times" aria-hidden="true"></i>
                    </div>
                    <saved-document-list @show-loader="showLoader" />
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
import DocumentBox from '../design/DocumentBox.vue';
import SavedDocumentList from '../design/SavedDocumentList.vue';
export default {
    data() {
        return {
            msg: '',
            typing: false,
            isDocOpen: false,
            setLoader: false,
            name: '',
        }
    },
    components: {
        ChatHead,
        DocumentBox,
        SavedDocumentList,
    },
    computed: {
        pageInfo() {
            return this.$store.state.documents.pageInfo;
        },
        chatList() {
            return this.$store.state.documents.chatList;
        },
        documentList() {
            return this.$store.state.documents.documentList;
        },
        translateLanguage() {
            return this.$store.state.chat.translateLanguage;
        },
    },
    methods: {
        getPageInfo() {
            let payload = {
                documentid: this.$route.params.documentid,
            };
            this.$store
                .dispatch('documents/get_documents_info', payload);
        },
        submit() {
            if(this.msg && this.documentList.length) {
                let msg = this.msg;
                let user = {
                    msg: msg,
                    user: 'user',
                };

                this.$store
                    .dispatch('documents/set_user_msg', user).then((response) => {
                        var container = this.$el.querySelector(".chat-body");
                        container.scrollTop = container.scrollHeight;
                    });
                
                this.typing = true;
                this.msg = '';
                
                let payload = {
                    msg: msg,
                    document_id: this.$route.params.documentid,
                }
                this.$store.dispatch('documents/document_chat', payload).then((response) => {
                    var container = this.$el.querySelector(".chat-body");
                    container.scrollTop = container.scrollHeight;
                    this.typing = false;
                });
            } else if (!this.documentList.length) {
                this.$notify({
                    group: 'error',
                    text: 'Please upload document or provide link.',
                    closeOnClick: true,
                });
            }
        },
        getDocuments() {
            this.$store.dispatch('documents/get_document_list', this.$route.params.documentid);
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
        closeDocument() {
            this.isDocOpen = false;
            this.$refs.editor.classList.remove('mobile-editor');
            this.$refs.chatContainer.classList.remove('remove-editor');
        },
        showLoader(value) {
            console.log(value);
            this.setLoader = value;
        },
        remove(docId, name) {
            this.$store.dispatch('documents/remove_document', { document_id: docId, name: name }).then((response) => {
                if(response.data) {
                    this.$notify({
                        group: 'success',
                        text: 'Deleted!',
                        closeOnClick: true,
                    });
                    this.name = '';
                    this.isStore = false;
                    this.$store.dispatch('documents/get_documents');
                    this.$router.push({ name: 'documentsList'});
                } else {
                    this.$notify({
                        group: 'error',
                        text: 'Something went wrong! Please reload the page.',
                        closeOnClick: true,
                    });
                    this.$router.push({ name: 'documentsList'});
                }
            });
        },
        save(){
            let payload = {
                id: this.pageInfo.id,
                list: this.chatList,
                name: this.name ? this.name : this.pageInfo.name,
            };

            this.$store.dispatch('documents/save', payload).then((response) => {
                this.name = '';
                this.$notify({
                    group: 'success',
                    text: 'Success! Saved.',
                    closeOnClick: true,
                });
                this.$router.push({ name: 'savedDocument', params: { documentid: this.$route.params.documentid }});
                this.getPageInfo();
            });
        },
        nameChange(val) {
            this.name = val;
            this.save(true);
        },
        clean() {
            this.$store.dispatch('documents/clean_chat');
            this.isTextareaMsg = '';
            this.combineMsg = [];
            this.isFirstMsg = true;
            this.typing = false;
        },
    },
    mounted() {
        this.$store.dispatch('documents/reset_state');
        this.$store.dispatch('chat/translate_language');
        this.getPageInfo();
        this.getDocuments();
    },
    watch: {
        $route(to, from) {
            this.$store.dispatch('documents/reset_state');
            this.$store.dispatch('chat/translate_language');
            this.getPageInfo();
        }
    }
}
</script>