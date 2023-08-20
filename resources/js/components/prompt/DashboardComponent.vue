<template>
	<div class="chatbox-container">
        <chat-head :name="`Template`"/>
        <section class="dashbaord-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 input-search-box">
                        <input type="text" v-model="term" @input="search" placeholder="Search..."/>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-3" v-for="(model, i) in models" :key="i">
                        <div class="model-section">
                            <router-link class="model" :to="{ name: 'chatBox', params: { prompt: model.slug.split('/')[2] }}">
                                <div class="img"><img :src="model.img" :style="{ 'border': '2px solid '+model.background }"></div>
                                <div class="content">
                                    <div class="name">{{ model.name }}</div>
                                    <div class="outline">{{ model.outline }}</div>
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
        models() {
            return this.$store.state.models.search ? this.$store.state.models.search : [];
        },
    },
    methods: {
        search() {
            this.$store.dispatch('models/get_search_models', this.term);
        },
    },
    mounted() {
        this.$store.dispatch('models/get_search_models');
    },
}
</script>