<template>
	<div class="chatbox-container document-container saved-fine-tune">
        <chat-head :name="pageInfo.name"/>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="section">
                            <div class="section-head">
                                <div class="section-name">
                                    <div class="name">Upload File</div>
                                    <div class="outline">Upload File in jsonl format. Once upload done it will generate file id.</div>
                                    <div class="my-3"><input type="file" ref="file" accept=".jsonl" @change="upload"></div>
                                </div>
                                <div class="section-status" v-if="pageInfo.file_id">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i> Done
                                </div>
                            </div>
                            <div class="section-body" v-if="pageInfo.file_id">
                                File Id: {{ pageInfo.file_id }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="section">
                            <div class="section-head">
                                <div class="section-name">
                                    <div class="name">Create Job</div>
                                    <div class="outline">Create a job for uploade file. This will generate job id.</div>
                                </div>
                                <div class="section-status" v-if="pageInfo.job_id">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i> Done
                                </div>
                            </div>
                            <div class="section-body" v-if="pageInfo.job_id">
                                Job Id: {{ pageInfo.job_id }}
                                <div class="text-muted small">Job Id is created. OpenAI will process fine tune and will create a new model id (You can find it under your OpenAI account). Once you get model id then go to DB. In table chat_suite_sections, add this id under model column.</div>
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
import ChatHead from '../design/ChatHead.vue';
export default {
    data() {
        return {
            setLoader: false,
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        pageInfo() {
            return this.$store.state.finetune.pageInfo;
        }
    },
    methods: {
        getPageInfo() {
            this.$store
                .dispatch('finetune/get_page_info', this.$route.params.id);
        },
        setProcessing(type=null){
            let payload = {
                id: this.$route.params.id,
                type: type
            }
            this.$store
                .dispatch('finetune/set_processing', payload);
        },
        upload() {
            this.setLoader = true;
            this.setProcessing('file');
            let formData = new FormData();
            formData.append('file', this.$refs.file.files[0]);
            formData.append('id', this.$route.params.id);
            this.$store
                .dispatch('finetune/upload_file', formData).then((response) => {
                    if(response.data.status == 'success'){
                        this.getPageInfo();
                        this.createJob();
                    } else {
                        this.setLoader = false;
                        this.$refs.file.value = null;
                        this.$notify({
                            group: 'error',
                            text: response.data.msg ? response.data.msg : 'Something went wrong! Please reload the page.',
                            closeOnClick: true,
                        });
                    }
                }).catch((error) => {
                    this.setLoader = false;
                    this.$refs.file.value = null;
                    this.$notify({
                        group: 'error',
                        text: 'Something went wrong! Please reload the page.',
                        closeOnClick: true,
                    });
            });
        },
        createJob() {
            this.setProcessing('job');
            
            let payload = {
                id: this.$route.params.id
            };

            this.$store
                .dispatch('finetune/create_job', payload).then((response) => {
                    if(response.data.status == 'success'){
                        this.getPageInfo();
                        this.setProcessing();
                        this.setLoader = false;
                        this.$refs.file.value = null;
                    } else {
                        this.setLoader = false;
                        this.$refs.file.value = null;
                        this.$notify({
                            group: 'error',
                            text: response.data.msg ? response.data.msg : 'Something went wrong! Please reload the page.',
                            closeOnClick: true,
                        });
                    }
                }).catch((error) => {
                    this.setLoader = false;
                    this.$refs.file.value = null;
                    this.$notify({
                        group: 'error',
                        text: 'Something went wrong! Please reload the page.',
                        closeOnClick: true,
                    });
            });
        },
        // eventList() {
        //     this.setProcessing('events');
            
        //     let payload = {
        //         id: this.$route.params.id
        //     };

        //     this.$store
        //         .dispatch('finetune/event_list', payload).then((response) => {
        //             if(response.data.status == 'success'){
        //                 this.getPageInfo();
        //                 this.eventList();
        //             } else {
        //                 this.$notify({
        //                     group: 'error',
        //                     text: response.data.msg ? response.data.msg : 'Something went wrong! Please reload the page.',
        //                     closeOnClick: true,
        //                 });
        //             }
        //         }).catch((error) => {
        //             this.$notify({
        //                 group: 'error',
        //                 text: 'Something went wrong! Please reload the page.',
        //                 closeOnClick: true,
        //             });
        //     });
        // }
    },
    mounted() {
        this.getPageInfo();
    },
    watch: {
        $route(to, from) {
            this.getPageInfo();
        }
    }
}
</script>