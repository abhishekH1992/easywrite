<template>
    <div class="documents">
        <div class="formbold-mb-5 formbold-file-input">
            <input type="file" id="file" ref="file" @change="upload" accept=".mp3,.mp4,.mpeg,.mpga,.m4a,.wav,.webm"/>
            <label for="file">
                <div>
                    <span class="formbold-drop-file"> Drop audio file </span>
                    <span class="formbold-or"> Or </span>
                    <span class="formbold-browse"> Browse </span>
                </div>
            </label>
        </div>
        <div class="document-list" v-if="audioList.length">
            <div class="audio-list" v-for="(list, key) in audioList" :key="key">
                <div class="list">
                    <div class="name">{{ list.name }}</div>
                    <div class="resend" @click="resend(list.id)"><i class="fa fa-repeat" aria-hidden="true"></i></div>
                    <div class="remove" @click="remove(list.id)"><i class="fa-solid fa-trash"></i></div>
                </div>
                <audio controls>
                    <source :src="list.link" type="audio/mpeg" name="hi">
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    computed: {
        audioList() {
            return this.$store.state.speech.audioList;
        },
    },
    methods: {
        getAudio() {
            this.$store.dispatch('speech/get_audio_list', this.$route.params.id);
        },
        upload() {
            this.$emit('show-loader', true);
            if(this.$refs.file.files[0].size > (25 * 1024) * 1024) {
                this.$emit('show-loader', false);
                this.$notify({
                    group: 'error',
                    text: 'Please uploade file less that 25MB.',
                    closeOnClick: true,
                });
            } else {
                let formData = new FormData();
                formData.append('file', this.$refs.file.files[0]);
                formData.append('speech_id', this.$route.params.id);
                this.$store
                    .dispatch('speech/upload_file', formData).then((response) => {
                    this.$emit('show-loader', false);
                    if(response.data) {
                        this.$notify({
                            group: 'success',
                            text: 'Uploaded!',
                            closeOnClick: true,
                        });
                        this.getAudio();
                        this.setChat(response.data);
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
        remove(audio_id) {
            this.$emit('show-loader', true);
            let payload = {
                id: audio_id
            };
            this.$store.dispatch('speech/remove_file', payload).then((response) => {
                this.$emit('show-loader', false);
                if(response.data) {
                    this.$notify({
                        group: 'success',
                        text: 'Removed!',
                        closeOnClick: true,
                    });
                    this.getAudio();
                } else {
                    this.$notify({
                        group: 'error',
                        text: 'Something went wrong! Please reload the page.',
                        closeOnClick: true,
                    });
                }
            });
        },
        resend(audio_id) {
            this.$emit('show-loader', true);
            let payload = {
                audio_id: audio_id,
            };
            this.$store.dispatch('speech/resend', payload).then((response) => {
                this.$emit('show-loader', false);
                this.setChat(response.data);
            });
                        
        },
        setChat(data) {
            let payload = {
                msg: data,
                user: 'ai'
            };
            this.$store.dispatch('speech/add_new_audio_chat', payload);
        }
    },
    mounted() {
        this.getAudio();
    },
}
</script>
