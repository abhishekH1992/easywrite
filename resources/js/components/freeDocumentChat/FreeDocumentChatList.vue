<template>
	<div class="chatbox-container document-container free-document-chat container">
        <div class="row head-title">
            <chat-head :name="`Chatbot List`" class="sm:col-6"/>
            <div class="sm:col-6 mt-4 sm:mt-0 input-search-box p-3">
                <input type="text" v-model="term" @input="search" placeholder="Search for chat document..."/>
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
        </div>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 new-document">
                        <button class="btn btn-submit" @click="showModal = true"><i class="fa fa-plus" aria-hidden="true"></i> 
                        <span class="d-sm-inline-block d-none">New</span></button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(item, i) in list" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="`easychat/`+item.slug">
                                <div class="content">
                                    <div class="img"><img :src="`/assets/images/document.png`" :style="{ 'border': '2px solid #fff' }"></div>
                                    <div class="name">
                                        {{ item.name }}
                                        <span class="created-date">Created: {{ item.human_readable_date }}</span>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="modal chatbot-list-modal" :class="{show: showModal}">
                        <div class="modal-dialog">
                            <div class="modal-content rounded-4">
                            <div class="modal-header border-0">
                                <h3 class="modal-title">New Chatbot</h3>
                                <button type="button" class="btn-close" @click="showModal = false"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label>Name</label>
                                    <input type="text" class="form-control bg-white" placeholder="Enter Name" v-model="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Slug</label>
                                    <input type="text" class="form-control bg-white" placeholder="Enter Slug"  v-model="slug">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Outline</label>
                                    <input type="text" class="form-control bg-white" placeholder="Enter outline"  v-model="outline">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Document:</label>
                                    <input type="file" ref="file" class="form-control bg-white" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn footer-btn" @click="submit">Save</button>
                                <button type="button" class="btn footer-btn  mr-3" @click="showModal = false">Cancel</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="loader-container" v-if="setLoader">
            <div class="loader"></div>
        </div>
    </div>
</template>

<script>
import ChatHead from '../design/ChatHead.vue'
export default {
    data() {
        return {
            term: '',
            showModal: false,
            name: '',
            outline: '',
            slug: '',
            setLoader: false,
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        list() {
            return this.$store.state.freeDocumentChat.list;
        },
    },
    methods: {
        search() {
            this.$store.dispatch('freeDocumentChat/get_list', this.term);
        },
        submit() {
            this.setLoader = true;
            let name = this.name.trim();
            let slug = this.slug.trim();
            if(!name) {
                this.name = '';
                this.$notify({
                    group: 'error',
                    text: 'Please type name to create new document chat!',
                    closeOnClick: true,
                });
                this.setLoader = false;
            } else if(!slug) {
                this.slug = '';
                this.$notify({
                    group: 'error',
                    text: 'Please type slug to create new document chat!',
                    closeOnClick: true,
                });
                this.setLoader = false;
            } else {
                let formData = new FormData();
                formData.append('file', this.$refs.file.files[0]);
                formData.append('name', this.name);
                formData.append('outline', this.outline);
                formData.append('slug', this.slug);
                this.$store.dispatch('freeDocumentChat/new_document', formData).then((response) => {
                    this.name = '';
                    this.outline = '';
                    this.slug = '';
                    this.showModal = false;
                    this.$refs.file.value = null;
                    this.setLoader = false;
                    if(response.data) {
                        this.$notify({
                            group: 'success',
                            text: 'Created!',
                            closeOnClick: true,
                        });
                        this.$store.dispatch('freeDocumentChat/get_list');
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
        this.$store.dispatch('freeDocumentChat/get_list');
    },
}
</script>
<style scoped>
.show {
    display: block;
}
</style>