<template>
    <div class="documents">
        <div class="formbold-mb-5 formbold-file-input">
            <input type="file" id="file" ref="file" @change="upload(false)" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf"/>
            <label for="file">
                <div>
                    <span class="formbold-drop-file"> Drop files here </span>
                    <span class="formbold-or"> Or </span>
                    <span class="formbold-browse"> Browse </span>
                </div>
            </label>
        </div>
        <div class="website-url">
            <div class="title">URL</div>
            <div class="link-input">
                <input type="url" v-model="link" placeholder="Insert a link"/>
                <button class="btn" @click="upload(true)">Upload Link</button>
            </div>
        </div>
        <div class="document-list" v-if="documentList.length">
            <div class="list" v-for="(list, key) in documentList" :key="key">
                <div class="name">{{ list.name }}</div>
                <div class="remove" @click="remove(list.document_unique)"><i class="fa-solid fa-trash"></i></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            link: '',
        }
    },
    computed: {
        documentList() {
            return this.$store.state.documents.documentList;
        },
    },
    methods: {
        upload(isLink = false) {
            this.$emit('show-loader', true);
            let formData;
            if(!isLink) {
                formData = new FormData();
                formData.append('file', this.$refs.file.files[0]);
                formData.append('documentid', this.$route.params.documentid);
            } else {
                formData = {
                    'newlink': this.link,
                    'documentid': this.$route.params.documentid,
                }
            }
            this.$store
                .dispatch('documents/upload_file', formData).then((response) => {
                this.$emit('show-loader', false);
                if(response.data) {
                    this.$notify({
                        group: 'success',
                        text: 'Uploaded!',
                        closeOnClick: true,
                    });
                    if(isLink) {
                        this.link = '';
                    }
                    this.getDocuments();
                } else {
                    this.$notify({
                        group: 'error',
                        text: 'Something went wrong! Please reload the page.',
                        closeOnClick: true,
                    });
                }
            });
        },
        getDocuments() {
            this.$store.dispatch('documents/get_document_list', this.$route.params.documentid);
        },
        remove(file_id) {
            this.$store
                .dispatch('documents/remove_document_file', { file_id: file_id }).then((response) => {
                if(response.data) {
                    this.$notify({
                        group: 'success',
                        text: 'Removed!',
                        closeOnClick: true,
                    });
                    this.getDocuments();
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
    mounted() {
        this.getDocuments();
    },
}
</script>
