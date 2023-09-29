<template>
	<div class="chatbox-container document-container">
        <chat-head :name="`Fine Tune`"/>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 new-document">
                        <button class="btn btn-submit" @click="showModal = true"><i class="fa fa-plus-circle" aria-hidden="true"></i> New</button>
                    </div>
                    <div class="col-12 input-search-box">
                        <input type="text" v-model="term" @input="search" placeholder="Search for fine tune..."/>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(item, i) in list" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="{ name: 'savedFineTune', params: { id: item.id }}">
                                <div class="content">
                                    <div class="name">{{ item.name }}</div>
                                    <div class="outline">Chat Suite: {{ item.chat_suite.name }}</div>
                                    <div class="outline">File Id: {{ item.file_id }}</div>
                                    <div class="outline">Job Id: {{ item.job_id }}</div>
                                    <div class="outline">Model: {{ item.model }}</div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal-mask" v-if="showModal">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h6>New Fine Tune</h6>
                    </div>  
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6 form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter name..." v-model="name">
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label>Chat Suite</label>
                                <select class="form-control" v-model="chat_suite_id">
                                    <option v-for="suite in chatSuiteList" :key="suite.id" :value="suite.id">{{ suite.name }}</option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label>Outline</label>
                                <input type="text" class="form-control" placeholder="Enter outline..." v-model="outline">
                            </div>
                            <div class="col-12 form-group">
                                <label>System Message</label>
                                <textarea class="form-control" placeholder="Enter system message..." row="2" v-model="system_msg"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn theme-btn" @click="submit()">Save</button>
                        <button class="btn theme-btn" @click="close()">Cancel</button>
                    </div>
                </div>
            </div>
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
            system_msg: '',
            chat_suite_id: '',
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        list() {
            return this.$store.state.finetune.list;
        },
        chatSuiteList() {
            return this.$store.state.finetune.chatSuiteList;
        },
    },
    methods: {
        search() {
            this.$store.dispatch('finetune/get_list', this.term);
        },
        submit() {
            let payload = {
                name: this.name.trim(),
                outline: this.outline.trim(),
                system_msg: this.system_msg.trim(),
                chat_suite_id: this.chat_suite_id,
            }

            this.$store.dispatch('finetune/new_submit', payload).then((response) => {
                if(response.data === true) {
                    this.$notify({
                        group: 'success',
                        text: 'Created!',
                        closeOnClick: true,
                    });
                    this.close();
                    this.$store.dispatch('finetune/get_list');
                } else {
                    this.$notify({
                        group: 'error',
                        text: response.data.join('\n'),
                        closeOnClick: true,
                    });
                }
            }).catch((error) => {
                console.log(error);
                this.$notify({
                    group: 'error',
                    text: 'Something went wrong! Please reload the page.',
                    closeOnClick: true,
                });
            });
        },
        close() {
            this.showModal = false;
            this.name = '';
            this.outline = '';
            this.system_msg = '';
            this.chat_suite_id = '';
        },
    },
    mounted() {
        this.$store.dispatch('finetune/get_list');
        this.$store.dispatch('finetune/get_chat_suite_list');
    },
}
</script>