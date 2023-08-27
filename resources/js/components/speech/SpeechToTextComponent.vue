<template>
	<div class="chatbox-container document-container">
        <chat-head :name="`Speech To Text`"/>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 new-document">
                        <input type="text" v-model="name" placeholder="New speech to text chat name ..." v-if="isStore"/>
                        <button class="btn btn-submit" @click="submit" v-if="isStore" :disable="!name">Save</button>
                        <button class="btn btn-submit" @click="isStore = false" v-if="isStore" :disable="!name">Cancel</button>
                        <button class="btn btn-submit" @click="isStore = true" v-if="!isStore"><i class="fa fa-plus-circle" aria-hidden="true"></i> New</button>
                    </div>
                    <div class="col-12 input-search-box">
                        <input type="text" v-model="term" @input="search" placeholder="Search for speech to text..."/>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(item, i) in list" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="{ name: 'savedSpeechToText', params: { id: item.id }}">
                                <div class="content">
                                    <div class="img"><i class="fa fa-file-audio" aria-hidden="true"></i></div>
                                    <div class="name">
                                        {{ item.name }}
                                        <span class="created-date">Created: {{ item.human_readable_date }}</span>
                                    </div>
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
            return this.$store.state.speech.list;
        },
    },
    methods: {
        search() {
            this.$store.dispatch('speech/get_speech_to_text', this.term);
        },
        submit() {
            let docName = this.name.trim();
            if(!docName) {
                this.name = '';
                this.$notify({
                    group: 'error',
                    text: 'Please type name to create new speech to text!',
                    closeOnClick: true,
                });
            } else {
                this.$store.dispatch('speech/new_chat', { name: docName }).then((response) => {
                    if(response.data) {
                        this.$notify({
                            group: 'success',
                            text: 'Created!',
                            closeOnClick: true,
                        });
                        this.name = '';
                        this.isStore = false;
                        this.$store.dispatch('speech/get_speech_to_text');
                    } else {
                        this.$notify({
                            group: 'error',
                            text: 'Something went wrong! Please reload the page.',
                            closeOnClick: true,
                        });
                        this.name = '';
                        this.isStore = false;
                    }
                });
            }
        },
    },
    mounted() {
        this.$store.dispatch('speech/get_speech_to_text');
    },
}
</script>