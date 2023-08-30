<template>
	<div class="chatbox-container document-container">
        <chat-head :name="pageInfo.name"/>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 input-search-box">
                        <input type="text" v-model="term" @input="getSectionsList" :placeholder="`Search for `+pageInfo.name+`...`"/>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(item, i) in sectionList" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="{ name: 'chatSuiteChat', params: { parent: this.$route.params.slug, slug: item.slug }}">
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
        pageInfo() {
            return this.$store.state.chatSuite.pageInfo;
        },
        sectionList() {
            return this.$store.state.chatSuite.sectionList;
        },
    },
    methods: {
        async getPageInfo() {
            await this.$store
                .dispatch('chatSuite/get_page_info', this.$route.params.slug).then((response) => {
                    this.getSectionsList();
                });
        },
        getSectionsList() {
            let payload = {
                id: this.pageInfo.id,
                term: this.term,
            }
            this.$store.dispatch('chatSuite/get_chat_suite_sections_child', payload);
        },
    },
    mounted() {
        this.getPageInfo();
    },
}
</script>