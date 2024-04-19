<template>
	<div class="chatbox-container document-container">
        <div class="row head-title">
            <chat-head :name="`Chat Suite`" class="sm:col-6"/>
            <div class="sm:col-6 mt-4 sm:mt-0 input-search-box p-3">
                <input type="text" v-model="term" @input="search" placeholder="Search for speech chat suite..."/>
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
        </div>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(item, i) in list" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="{ name: 'chatSuiteSections', params: { slug: item.slug }}">
                                <div class="content">
                                    <div class="img"><i class="fas fa-comment-alt" aria-hidden="true"></i></div>
                                    <div class="name">{{ item.name }}</div>
                                    <div class="outline">{{ item.outline }}</div>
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
        }
    },
    components: {
        ChatHead,
    },
    computed: {
        list() {
            return this.$store.state.chatSuite.list;
        },
    },
    methods: {
        search() {
            this.$store.dispatch('chatSuite/get_chat_suite_sections', this.term);
        },
    },
    mounted() {
        this.$store.dispatch('chatSuite/get_chat_suite_sections');
    },
}
</script>