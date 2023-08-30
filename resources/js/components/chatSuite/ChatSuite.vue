<template>
	<div class="chatbox-container document-container">
        <chat-head :name="`Chat Suite`"/>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 input-search-box">
                        <input type="text" v-model="term" @input="search" placeholder="Search for chat suite..."/>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
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