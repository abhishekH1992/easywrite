<template>
	<div class="chatbox-container document-container container">
        <div class="row head-title">
            <chat-head :name="`Chat Documents List`" class="sm:col-6"/>
            <div class="sm:col-6 mt-4 sm:mt-0 input-search-box p-3">
                <input type="text" v-model="term" @input="search" placeholder="Search for chat document..."/>
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
        </div>
        
        <section class="dashbaord-section p-0">
            <div class="container">
                <div class="row">
                    <div class="col-12 new-document">
                        <input type="text" class="speech-input" v-model="name" placeholder="New document chat name..." v-if="isStore"/>
                        <button class="btn btn-submit btn-save mx-3" @click="submit" v-if="isStore" :disable="!name">Save</button>
                        <button class="btn btn-submit btn-cancel" @click="isStore = false" v-if="isStore" :disable="!name">Cancel</button>
                        <button class="btn btn-submit" @click="isStore = true" v-if="!isStore"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>New</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(item, i) in list" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="{ name: 'savedDocument', params: { documentid: item.document_id }}">
                                <div class="content">
                                    <div class="img speech-text-img"><i class="fa fa-pencil-square" aria-hidden="true"></i></div>
                                    <div class="name">{{ item.name }}</div>
                                    <div class="created-date">Created: {{ item.human_readable_date }}</div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import ChatHead from '../design/ChatHead.vue'
export default {
    data() {
        return {
            term: '',
            isStore: false,
            name: '',
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        list() {
            return this.$store.state.documents.list;
        },
    },
    methods: {
        search() {
            this.$store.dispatch('documents/get_documents', this.term);
        },
        submit() {
            let docName = this.name.trim();
            if(!docName) {
                this.name = '';
                this.$notify({
                    group: 'error',
                    text: 'Please type name to create new document chat!',
                    closeOnClick: true,
                });
            } else {
                this.$store.dispatch('documents/new_document', { name: docName }).then((response) => {
                    if(response.data) {
                        this.$notify({
                            group: 'success',
                            text: 'Created!',
                            closeOnClick: true,
                        });
                        this.name = '';
                        this.isStore = false;
                        this.$store.dispatch('documents/get_documents');
                    } else {
                        this.$notify({
                            group: 'error',
                            text: 'Something went wrong! Please reload the page.',
                            closeOnClick: true,
                        });
                    }
                });
            }
        },
    },
    mounted() {
        this.$store.dispatch('documents/get_documents');
    },
}
</script>